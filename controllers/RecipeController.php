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
        $recipe->scenario = Recipe::SCENARIO_CREATE;

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
            $recipe->featureImage = UploadedFile::getInstance($recipe, 'featureImage');
            if ($recipe->validate()) {
                if ($recipe->uploadFeature()) {
                    Yii::$app->db->transaction(function ($db) use ($recipe, $ingredients, $directions, $tag) {
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
        $recipe->scenario = Recipe::SCENARIO_UPDATE;

        $ingredients = [];
        foreach ($recipe->ingredients as $ingredient) {
            $ingredients[] = $ingredient;
        }

        $directions = [];
        foreach ($recipe->directions as $direction) {
            $directions[] = $direction;
        }

        $tag = new Tag();
        $tag->tag = implode(',', $recipe->getTags()->select('tag')->column());

        $category = new Category();
        $categories = $category->findCategoryList();

        if (Yii::$app->request->isPost) {
            $countIngredient = count(Yii::$app->request->post('Ingredient', []));
            $ingredients = [];
            for ($i = 0; $i < $countIngredient; $i++) {
                $ingredients[] = new Ingredient();
            }

            $countDirection = count(Yii::$app->request->post('Direction', []));
            $directions = [];
            for ($i = 0; $i < $countDirection; $i++) {
                $directions[] = new Direction();
            }
        }

        /* @var $user User */
        $user = Yii::$app->user->identity;

        $recipe->user_id = Yii::$app->user->id;
        $recipeLoaded = $recipe->load(Yii::$app->request->post());
        $ingredientsLoaded = Model::loadMultiple($ingredients, Yii::$app->request->post());
        $directionsLoaded = Model::loadMultiple($directions, Yii::$app->request->post());
        $tagLoaded = $tag->load(Yii::$app->request->post());

        if ($recipeLoaded && $ingredientsLoaded && $directionsLoaded && $tagLoaded) {

            $recipe->featureImage = UploadedFile::getInstance($recipe, 'featureImage');
            if ($recipe->validate()) {
                if (!is_null($recipe->featureImage)) {
                    $oldFeature = $recipe->feature;
                    $upload = $recipe->uploadFeature();
                    if ($upload) {
                        @unlink(Yii::getAlias('@webroot') . '/img/recipes/' . $oldFeature);
                    }
                } else {
                    $upload = true;
                }

                if ($upload) {
                    Yii::$app->db->transaction(function ($db) use ($recipe, $ingredients, $directions, $tag) {
                        $recipe->safeSlug($recipe->id);
                        $recipe->save(false);

                        Ingredient::deleteAll(['recipe_id' => $recipe->id]);
                        foreach ($ingredients as $ingredient) {
                            if (!is_null($ingredient->ingredient)) {
                                $recipe->link('ingredients', $ingredient);
                            }
                        }

                        Direction::deleteAll(['recipe_id' => $recipe->id]);
                        foreach ($directions as $direction) {
                            if (!is_null($direction->direction)) {
                                $recipe->link('directions', $direction);
                            }
                        }

                        Yii::$app->db->createCommand()
                            ->delete('recipe_tags', ['recipe_id' => $recipe->id])
                            ->execute();
                        $tagSynced = $tag->checkSyncTags($tag->tag);
                        foreach ($tagSynced as $tagItem) {
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
            'ingredients' => $ingredients,
            'direction' => $direction,
            'directions' => $directions,
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

}
