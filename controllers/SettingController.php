<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\base\ViewContextInterface;
use yii\web\Controller;
use yii\web\HttpException;

class SettingController extends Controller implements ViewContextInterface
{
    public function getViewPath()
    {
        return Yii::getAlias('@app/views/setting');
    }

    public function actionApplication()
    {
        $user = Yii::$app->user->identity;

        $zones = array();
        $timestamp = time();
        foreach(timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones[$zone] = 'UTC/GMT ' . date('P', $timestamp) . ' - ' . $zone;
        }

        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
        return $this->render('application', [
            'user' => $user,
            'zones' => $zones
        ]);
    }

    public function actionProfile()
    {
        $user = Yii::$app->user->identity;
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
        return $this->render('profile', [
            'user' => $user
        ]);
    }

    public function actionPassword()
    {
        $user = Yii::$app->user->identity;
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
        return $this->render('password', [
            'user' => $user
        ]);
    }

    public function actionSecurity()
    {
        $user = Yii::$app->user->identity;
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
        return $this->render('security', [
            'user' => $user
        ]);
    }

    public function actionNotification()
    {
        $user = Yii::$app->user->identity;
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
        return $this->render('notification', [
            'user' => $user
        ]);
    }


    public function actionSocial()
    {
        $user = Yii::$app->user->identity;
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
        return $this->render('social', [
            'user' => $user
        ]);
    }

    public function actionPrivacy()
    {
        $user = Yii::$app->user->identity;
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
        return $this->render('privacy', [
            'user' => $user
        ]);
    }

    public function actionAccessibility()
    {
        $user = Yii::$app->user->identity;
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
        return $this->render('accessibility', [
            'user' => $user
        ]);
    }

}
