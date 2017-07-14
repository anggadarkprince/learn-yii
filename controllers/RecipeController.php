<?php

namespace app\controllers;

use app\models\Category;
use app\models\Direction;
use app\models\Ingredient;
use app\models\Recipe;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
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
        $direction = new Direction();
        $category = new Category();
        $categories = $category->findCategoryList();
        $user = Yii::$app->user->identity;

        $recipe->user_id = Yii::$app->user->id;
        $recipeLoaded = $recipe->load(Yii::$app->request->post());
        $ingredientLoaded = $ingredient->load(Yii::$app->request->post());
        $directionLoaded = $direction->load(Yii::$app->request->post());
        if ($recipeLoaded && $ingredientLoaded && $directionLoaded) {
            $isValidRecipe = $recipe->validate();
            $isValidIngredient = $ingredient->validate();
            $isValidDirection = $direction->validate();
            $isValid = $isValidRecipe && $isValidIngredient && $isValidDirection;

            if ($isValid) {
                $recipe->feature = UploadedFile::getInstance($recipe, 'feature');
                $recipe->uploadFeature();
                $recipe->save(false);
                $ingredient->save(false);
                $direction->save(false);
                return $this->redirect(["/{$user->username}"]);
            }

            Yii::$app->session->setFlash('status', 'danger');
            Yii::$app->session->setFlash('message', 'Something went wrong');
        }

        return $this->render('create', [
            'user' => $user,
            'recipe' => $recipe,
            'ingredient' => $ingredient,
            'direction' => $direction,
            'categories' => $categories
        ]);
    }

    /**
     * Action to perform saving new recipe data.
     * @return string form create view
     */
    public function actionSave()
    {
        $model = new RecipeForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // valid data received in $model

            // do something meaningful here about $model ...

            return $this->render('create-confirm', ['model' => $model]);
        } else {
            // either the page is initially displayed or there is some validation error
            return $this->render('create', ['model' => $model]);
        }
    }

    /**
     * Action to show edit form recipe by slug.
     * @param $slug unique recipe title id
     * @return string form edit view
     */
    public function actionEdit($slug)
    {
        return $this->render('edit');
    }

    /**
     * Action to update recipe data by slug.
     * @param $slug unique recipe title id
     */
    public function actionUpdate($slug)
    {

    }

    /**
     * Action to delete single recipe by slug.
     * @param $slug unique recipe title id
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

    /**
     * Finds the Category model based on its slug key.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $slug
     * @return Recipe the loaded model
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
