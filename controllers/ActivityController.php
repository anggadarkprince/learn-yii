<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ActivityController extends Controller
{
    public function actionIndex()
    {
        $this->viewPath = Yii::getAlias('@app/views/user');
        $user = Yii::$app->user->identity;
        return $this->render('activity', [
            'user' => $user
        ]);
    }

}
