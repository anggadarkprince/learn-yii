<?php

namespace app\controllers;

use app\models\Category;
use app\models\Direction;
use app\models\Ingredient;
use app\models\Recipe;
use app\models\Tag;
use app\models\User;
use Yii;
use yii\base\Model;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class RecipeController extends Controller
{
    /**
     * Show list recipe data.
     * @return string index list of recipe
     */
    public function actionIndex()
    {
        $recipeQuery = Recipe::find();

        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $recipeQuery->count(),
        ]);

        $recipes = $recipeQuery->orderBy(['created_at' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->with('user')
            ->all();

        return $this->render('index', [
            'recipes' => $recipes,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Displays a single Recipe model.
     * @param string $slug
     * @return mixed
     */
    public function actionView($slug)
    {
        $recipe = $this->findModelBySlug($slug);
        return $this->render('view', [
            'recipe' => $recipe,
            'ingredients' => $recipe->ingredients,
            'directions' => $recipe->directions,
            'tags' => $recipe->tags,
            'ratings' => $recipe->ratings,
            'recommendations' => $recipe->relatedRecipes,
        ]);
    }

    /**
     * Action to show create new recipe form.
     * @return string form create view
     */
    public function actionCreate()
    {
        $recipe = new Recipe();

        $ingredient = new Ingredient();
        $countIngredient = count(Yii::$app->request->post('Ingredient', []));
        $ingredients = [];
        for ($i = 0; $i < $countIngredient; $i++) {
            $ingredients[] = new Ingredient();
        }

        $direction = new Direction();
        $countDirection = count(Yii::$app->request->post('Direction', []));
        $directions = [];
        for ($i = 0; $i < $countDirection; $i++) {
            $directions[] = new Direction();
        }

        $tag = new Tag();
        $category = new Category();
        $categories = $category->findCategoryList();

        /* @var $user User */
        $user = Yii::$app->user->identity;

        $recipe->user_id = Yii::$app->user->id;
        $recipeLoaded = $recipe->load(Yii::$app->request->post());
        $ingredientsLoaded = Model::loadMultiple($ingredients, Yii::$app->request->post());
        $directionsLoaded = Model::loadMultiple($directions, Yii::$app->request->post());
        $tagLoaded = $tag->load(Yii::$app->request->post());

        if ($recipeLoaded && $ingredientsLoaded && $directionsLoaded && $tagLoaded) {

            if ($recipe->validate()) {
                $recipe->featureImage = UploadedFile::getInstance($recipe, 'feature');

                if ($recipe->uploadFeature()) {
                    Yii::$app->db->transaction(function ($db) use ($recipe, $ingredients, $directions, $tag, $user) {
                        $recipe->safeSlug();
                        $recipe->save(false);

                        foreach ($ingredients as $ingredient) {
                            if (!is_null($ingredient->ingredient)) {
                                $recipe->link('ingredients', $ingredient);
                            }
                        }

                        foreach ($directions as $direction) {
                            if (!is_null($direction->direction)) {
                                $recipe->link('directions', $direction);
                            }
                        }

                        $tagSynced = $tag->checkSyncTags($tag->tag);
                        foreach ($tagSynced as $tagItem) {
                            $recipe->link('tags', $tagItem);
                        }
                    });

                    Yii::$app->session->setFlash('status', 'success');
                    Yii::$app->session->setFlash('message', 'Create recipe <strong>' . $recipe->title . '</strong> success.');
                    return $this->redirect(["/{$user->username}"]);
                } else {
                    Yii::$app->session->setFlash('status', 'danger');
                    Yii::$app->session->setFlash('message', 'Upload feature data failed, try again.');
                }
            } else {
                Yii::$app->session->setFlash('status', 'warning');
                Yii::$app->session->setFlash('message', 'Invalid input data, please check again.');
            }
        }

        return $this->render('create', [
            'user' => $user,
            'recipe' => $recipe,
            'ingredient' => $ingredient,
            'ingredients' => $ingredients,
            'direction' => $direction,
            'directions' => $directions,
            'tag' => $tag,
            'categories' => $categories
        ]);
    }

    /**
     * Action to show edit form recipe by slug.
     * @param $slug string unique recipe title id
     * @return string string form edit view
     */
    public function actionEdit($slug)
    {
        $recipe = $this->findModelBySlug($slug);
        $ingredientData = $recipe->getIngredients()->select('ingredient')->column();
        $directionData = $recipe->getDirections()->select('direction')->column();
        $tagData = $recipe->getTags()->select('tag')->column();

        $ingredient = new Ingredient();
        $ingredient->ingredient = implode('||', $ingredientData);

        $direction = new Direction();
        $direction->direction = implode('||', $directionData);

        $tag = new Tag();
        $tag->tag = implode('||', $tagData);

        $category = new Category();
        $categories = $category->findCategoryList();

        /* @var $user User */
        $user = Yii::$app->user->identity;

        $recipe->user_id = Yii::$app->user->id;
        $recipeLoaded = $recipe->load(Yii::$app->request->post());
        $ingredientLoaded = $ingredient->load(Yii::$app->request->post());
        $directionLoaded = $direction->load(Yii::$app->request->post());
        $tagLoaded = $tag->load(Yii::$app->request->post());

        if ($recipeLoaded && $ingredientLoaded && $directionLoaded && $tagLoaded) {

            if ($recipe->validate()) {
                $recipe->featureImage = UploadedFile::getInstance($recipe, 'feature');
                if (!is_null($recipe->featureImage)) {
                    echo 'upload first';
                    $upload = $recipe->uploadFeature();
                } else {
                    echo 'without upload';
                    $upload = true;
                }

                if ($upload) {
                    Yii::$app->db->transaction(function ($db) use ($recipe, $ingredient, $direction, $tag, $user) {
                        $recipeSlug = $recipe->slug;
                        $totalFound = Recipe::find()->where(['slug' => $recipe->slug])->count();
                        if ($totalFound > 0) {
                            $recipeSlug .= '-' . ($totalFound + 1);
                        }
                        $recipe->slug = $recipeSlug;
                        $recipe->save(false);

                        Ingredient::deleteAll(['recipe_id' => $recipe->id]);
                        $ingredientData = explode('||', $ingredient->ingredient);
                        foreach ($ingredientData as $ingredientDatum) {
                            $ingredientItem = new Ingredient();
                            $ingredientItem->ingredient = $ingredientDatum;
                            $recipe->link('ingredients', $ingredientItem);
                        }

                        Direction::deleteAll(['recipe_id' => $recipe->id]);
                        $directionData = explode('||', $direction->direction);
                        foreach ($directionData as $directionDatum) {
                            $directionItem = new Direction();
                            $directionItem->direction = $directionDatum;
                            $recipe->link('directions', $directionItem);
                        }

                        Tag::deleteAll(['recipe_id' => $recipe->id]);
                        $tagsData = explode('||', $tag->tag);
                        foreach ($tagsData as $tagsDatum) {
                            $tagSlug = Inflector::slug($tag->tag);
                            $totalFound = Tag::find()->where(['slug' => $tagSlug])->count();
                            if ($totalFound > 0) {
                                $tagSlug .= '-' . ($totalFound + 1);
                            }
                            $tagItem = new Tag();
                            $tagItem->slug = $tagSlug;
                            $tagItem->tag = $tagsDatum;
                            $tagItem->save();
                            $recipe->link('tags', $tagItem);
                        }
                    });
                    Yii::$app->session->setFlash('status', 'success');
                    Yii::$app->session->setFlash('message', 'Update recipe <strong>' . $recipe->title . '</strong> success.');
                    return $this->redirect(["/{$user->username}"]);
                } else {
                    Yii::$app->session->setFlash('status', 'danger');
                    Yii::$app->session->setFlash('message', 'Upload feature data failed, try again.');
                }
            } else {
                Yii::$app->session->setFlash('status', 'warning');
                Yii::$app->session->setFlash('message', 'Invalid input data, please check again.');
            }
        }

        return $this->render('edit', [
            'user' => $user,
            'recipe' => $recipe,
            'ingredient' => $ingredient,
            'direction' => $direction,
            'tag' => $tag,
            'categories' => $categories
        ]);
    }

    /**
     * Action to delete single recipe by slug.
     * @param $slug string unique recipe title id
     * @return \yii\web\Response
     */
    public function actionDelete($slug)
    {
        $recipe = $this->findModelBySlug($slug);

        if ($recipe->delete()) {
            /* @var $user User */
            $user = Yii::$app->user->identity;

            @unlink(Yii::getAlias('@webroot') . '/img/recipes/' . $recipe->feature);

            Yii::$app->session->setFlash('status', 'warning');
            Yii::$app->session->setFlash('message', 'Deleting recipe <strong>' . $recipe->title . '</strong> success.');

            return $this->redirect(["/{$user->username}"]);
        }

        Yii::$app->session->setFlash('status', 'danger');
        Yii::$app->session->setFlash('message', 'Something went wrong, try again.');

        return $this->goBack();
    }

    /**
     * Finds the Category model based on its slug key.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $slug
     * @return Recipe|ActiveRecord|NotFoundHttpException the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBySlug($slug)
    {
        if (($model = Recipe::find()->where(['slug' => $slug])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function syncTags($recipeId, $oldTags, $newTagIds)
    {

        $oldTagIds = ArrayHelper::getColumn($oldTags, 'id');

        $tagToDelete = array_diff($oldTagIds, $newTagIds);
        $tagToAdd = array_diff($newTagIds, $oldTagIds);

        if ($tagToDelete) {
            //delete tags
            Yii::$app->db->createCommand()
                ->delete('recipe_tag', ['recipe_id' => $recipeId, 'tag_id' => $tagToDelete])
                ->execute();
        }

        if ($tagToAdd) {
            //link new tag associated with the recipe
            foreach ($tagToAdd as $value) {
                $tag = Tag::findOne($value);
                $this->link('tags', $tag);
            }
        }
    }

}
