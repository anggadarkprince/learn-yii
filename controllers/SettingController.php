<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\base\ViewContextInterface;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\UploadedFile;

class SettingController extends Controller implements ViewContextInterface
{
    /**
     * Set default view path.
     * @return bool|string
     */
    public function getViewPath()
    {
        return Yii::getAlias('@app/views/setting');
    }

    /**
     * Show and save changes of application settings.
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionApplication()
    {
        /* @var $user \app\models\User */
        $user = Yii::$app->user->identity;
        $user->scenario = User::SCENARIO_SETTING_APPLICATION;

        $zones = array();
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zones[$zone] = 'UTC/GMT ' . date('P', $timestamp) . ' - ' . $zone;
        }

        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('status', 'success');
            Yii::$app->session->setFlash('message', 'Application setting is updated!');
            return $this->refresh();
        }

        return $this->render('application', [
            'user' => $user,
            'zones' => $zones
        ]);
    }

    /**
     * Show and save changes of profile settings.
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionProfile()
    {
        /* @var $user \app\models\User */
        $user = Yii::$app->user->identity;
        $user->scenario = User::SCENARIO_SETTING_PROFILE;

        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }

        $user->avatarImage = UploadedFile::getInstance($user, 'avatarImage');
        if (!is_null($user->avatarImage)) {
            $upload = $user->uploadImage($user->avatarImage, 'img/avatars/', 'avatar_' . $user->id);
            if ($upload != false) {
                $user->avatar = $upload;
            }
        }
        $user->coverImage = UploadedFile::getInstance($user, 'coverImage');
        if (!is_null($user->coverImage)) {
            $upload = $user->uploadImage($user->coverImage, 'img/covers/', 'cover_' . $user->id);
            if ($upload != false) {
                $user->cover = $upload;
            }
        }

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('status', 'success');
            Yii::$app->session->setFlash('message', 'Account profile is updated!');
            return $this->refresh();
        }

        return $this->render('profile', [
            'user' => $user
        ]);
    }

    /**
     * Show and save changes of password settings.
     * @return string
     * @throws HttpException
     */
    public function actionPassword()
    {
        /* @var $user \app\models\User */
        $user = Yii::$app->user->identity;
        $user->scenario = User::SCENARIO_SETTING_PASSWORD;

        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }

        if ($user->load(Yii::$app->request->post()) && $user->validate()) {
            $user->password = password_hash($user->new_password, CRYPT_BLOWFISH);
            if ($user->save(false)) {
                Yii::$app->session->setFlash('status', 'success');
                Yii::$app->session->setFlash('message', 'Your password is updated!');
            } else {
                Yii::$app->session->setFlash('status', 'danger');
                Yii::$app->session->setFlash('message', 'Update password failed, try again!');
            }
            return $this->refresh();
        }

        return $this->render('password', [
            'user' => $user
        ]);
    }

    /**
     * Show and save changes of security settings.
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionSecurity()
    {
        /* @var $user \app\models\User */
        $user = Yii::$app->user->identity;
        $user->scenario = User::SCENARIO_SETTING_SECURITY;

        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('status', 'success');
            Yii::$app->session->setFlash('message', 'Security setting is updated!');
            return $this->refresh();
        }

        return $this->render('security', [
            'user' => $user
        ]);
    }

    /**
     * Show and save changes of notification settings.
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionNotification()
    {
        /* @var $user \app\models\User */
        $user = Yii::$app->user->identity;
        $user->scenario = User::SCENARIO_SETTING_NOTIFICATION;

        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('status', 'success');
            Yii::$app->session->setFlash('message', 'Notification setting is updated!');
            return $this->refresh();
        }

        return $this->render('notification', [
            'user' => $user
        ]);
    }


    /**
     * Connect and integrate social account.
     * @return string
     * @throws HttpException
     */
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

    /**
     * Show and save changes of privacy settings.
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionPrivacy()
    {
        /* @var $user \app\models\User */
        $user = Yii::$app->user->identity;
        $user->scenario = User::SCENARIO_SETTING_PRIVACY;

        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('status', 'success');
            Yii::$app->session->setFlash('message', 'Privacy setting is updated!');
            return $this->refresh();
        }

        return $this->render('privacy', [
            'user' => $user
        ]);
    }

    /**
     * Show and save changes of accessibility settings.
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionAccessibility()
    {
        /* @var $user \app\models\User */
        $user = Yii::$app->user->identity;
        $user->scenario = User::SCENARIO_SETTING_ACCESSIBILITY;

        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('status', 'success');
            Yii::$app->session->setFlash('message', 'Accessibility setting is updated!');
            return $this->refresh();
        }

        return $this->render('accessibility', [
            'user' => $user
        ]);
    }

}
