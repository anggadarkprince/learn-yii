<?php

namespace app\controllers;

use yii\web\Controller;

class LegalController extends Controller
{
    public function actionTermsOfService()
    {
        return $this->render('tos');
    }

    public function actionPrivacy()
    {
        return $this->render('privacy');
    }

}
