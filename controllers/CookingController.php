<?php

namespace app\controllers;

use yii\web\Controller;

class CookingController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
