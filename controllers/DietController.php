<?php

namespace app\controllers;

use yii\web\Controller;

class DietController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
