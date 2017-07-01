<?php

namespace app\controllers;

class ArticleController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
