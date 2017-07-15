<?php

namespace app\controllers;

use app\models\Category;
use app\models\Direction;
use app\models\Ingredient;
use app\models\Recipe;
use app\models\Tag;
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\db\ActiveRecord;
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

    /**
     * Action to show create new recipe form.
     * @return string form create view
     */
    public function actionCreate()
    {
        $recipe = new Recipe();
        $ingredient = new Ingredient();
        $direction = new Direction();
        $tag = new Tag();
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
                if ($recipe->uploadFeature()) {
                    Yii::$app->db->transaction(function ($db) use ($recipe, $ingredient, $direction, $tag, $user) {
                        $recipeSlug = $recipe->slug;
                        $totalFound = Recipe::find()->where(['slug' => $recipe->slug])->count();
                        if ($totalFound > 0) {
                            $recipeSlug .= '-' . ($totalFound + 1);
                        }
                        $recipe->slug = $recipeSlug;
                        $recipe->save(false);

                        $ingredientData = explode(',', $ingredient->ingredient);
                        foreach ($ingredientData as $ingredientDatum) {
                            $ingredientItem = new Ingredient();
                            $ingredientItem->ingredient = $ingredientDatum;
                            $recipe->link('ingredients', $ingredientItem);
                        }

                        $directionData = explode(',', $direction->direction);
                        foreach ($directionData as $directionDatum) {
                            $directionItem = new Direction();
                            $directionItem->direction = $directionDatum;
                            $recipe->link('directions', $directionItem);
                        }

                        $tagsData = explode(',', $tag->tag);
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
            'direction' => $direction,
            'tag' => $tag,
            'categories' => $categories
        ]);
    }

    /**
     * Action to show edit form recipe by slug.
     * @param $slug unique recipe title id
     * @return string string form edit view
     */
    public function actionEdit($slug)
    {
        return $this->render('edit');
    }

    /**
     * Action to update recipe data by slug.
     * @param $slug string unique recipe title id
     */
    public function actionUpdate($slug)
    {

    }

    /**
     * Action to delete single recipe by slug.
     * @param $slug string unique recipe title id
     */
    public function actionDelete($slug)
    {

    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Recipe the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelById($id)
    {
        if (($model = Recipe::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
