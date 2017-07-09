<?php

namespace app\controllers;

use app\models\Recipe;
use app\models\User;
use yii\web\Controller;

class DiscoveryController extends Controller
{
    public $layout = 'main_full';

    public function actionIndex()
    {
        $recipe = new Recipe();
        $recipes = $recipe->featuredRecipes;

        $users = User::find()->limit(4)->all();
        return $this->render('index', [
            'recipes' => $recipes,
            'users' => $users
        ]);
    }

}
