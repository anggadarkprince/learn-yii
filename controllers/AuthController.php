<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\ResetForm;
use app\models\User;
use app\models\UserToken;
use Yii;
use yii\db\Exception;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;

class AuthController extends Controller
{
    /**
     * Login action.
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = $model->getUser();
            if (!is_null($user)) {
                if ($user->status == User::STATUS_PENDING) {
                    $tokenData = $user->getTokens()->where(['type' => UserToken::TYPE_REGISTRATION])->one();
                    $link = Html::a('click here', Url::toRoute(['auth/confirmation',
                        'token' => $tokenData['key']
                    ]));
                    Yii::$app->session->setFlash('status', 'danger');
                    Yii::$app->session->setFlash('message', 'Account need activation, ' . $link . ' to resend email confirmation');
                } else if ($user->status == User::STATUS_SUSPENDED) {
                    Yii::$app->session->setFlash('status', 'danger');
                    Yii::$app->session->setFlash('message', 'Your account was suspended, contact our team support to fix this');
                } else if ($model->login()) {
                    $redirect = Yii::$app->request->get('redirect', '/' . Yii::$app->user->identity->username);
                    return $this->redirect($redirect);
                }
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     * @return yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Show register form.
     * @return string
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $user = new User();
                $user->name = $model->name;
                $user->username = $model->username;
                $user->email = $model->email;
                $user->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
                $user->status = User::STATUS_PENDING;
                $user->save();

                $token = Yii::$app->getSecurity()->generateRandomString();
                $userToken = new UserToken();
                $userToken->key = $token;
                $userToken->type = UserToken::TYPE_REGISTRATION;
                $userToken->link('user', $user);

                $transaction->commit();

                $model->sendActivationEmail($user, $token);

                return $this->redirect(Url::toRoute(['auth/confirmation',
                    'token' => $token
                ]));
            } catch (Exception $e) {
                $transaction->rollBack();

                Yii::$app->session->setFlash('status', 'danger');
                Yii::$app->session->setFlash('message', $e->getMessage());
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Show registered user.
     * @param $token
     * @return string
     * @throws HttpException
     */
    public function actionConfirmation($token)
    {
        $tokenData = UserToken::findOne(['key' => $token]);
        if (is_null($tokenData)) {
            throw new HttpException(404, 'Invalid user activation token');
        }

        $userData = $tokenData->user;
        if ($userData->status != User::STATUS_PENDING) {
            throw new HttpException(400, 'Your account was ' . $userData->status);
        }

        if (Yii::$app->request->isPost) {
            $register = new RegisterForm();
            $register->sendActivationEmail($userData, $token);
        }

        $model = new LoginForm();
        return $this->render('confirmation', [
            'user' => $userData,
            'token' => $token,
            'model' => $model
        ]);
    }

    /**
     * Activating user account by token.
     * @param $token
     * @throws HttpException
     */
    public function actionActivate($token)
    {
        $tokenData = UserToken::findOne(['key' => $token]);
        if (is_null($tokenData)) {
            throw new HttpException(404, 'Invalid user activation token');
        }

        $userData = $tokenData->user;
        if ($userData->status != User::STATUS_PENDING) {
            throw new HttpException(400, 'Your account was ' . $userData->status);
        }

        // set default flash message
        $status = 'success';
        $message = 'Your account successfully activated';

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // update user status
            $userData->status = User::STATUS_ACTIVATED;
            $userData->save();

            // delete user token for activation
            $tokenData->delete();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            $status = 'danger';
            $message = 'Something went wrong';
        }

        Yii::$app->session->setFlash('status', $status);
        Yii::$app->session->setFlash('message', $message);

        $this->redirect(Url::toRoute('auth/login'));
    }

    /**
     * Request reset password form.
     * @return bool|string
     */
    public function actionForgot()
    {
        $model = new ResetForm();
        $model->scenario = ResetForm::SCENARIO_RESET;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $user = User::findByEmail($model->email);

            /* @var $tokenModel UserToken */
            $tokenModel = $user->getTokens()->where(['type' => UserToken::TYPE_PASSWORD])->one();
            if (is_null($tokenModel)) {
                $token = Yii::$app->getSecurity()->generateRandomString();
                $userToken = new UserToken();
                $userToken->key = $token;
                $userToken->type = UserToken::TYPE_PASSWORD;
                $userToken->link('user', $user);
            } else {
                $token = $tokenModel->key;
            }
            $model->sendResetEmail($user, $token);

            Yii::$app->session->setFlash('status', 'warning');
            Yii::$app->session->setFlash('message', 'We have sent you reset email to ' . $model->email);

            return $this->redirect(['login']);
        }

        return $this->render('forgot', [
            'model' => $model,
        ]);
    }

    /**
     * Resetting password.
     * @param $token
     * @return bool|string
     * @throws HttpException
     */
    public function actionReset($token)
    {
        $tokenModel = UserToken::findOne(['key' => $token]);
        if (is_null($tokenModel)) {
            throw new HttpException(404, 'Invalid user reset token');
        }

        $userModel = $tokenModel->user;

        $model = new ResetForm();
        $model->email = $userModel->email;
        $model->token = $token;
        $model->scenario = ResetForm::SCENARIO_RECOVERY;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $status = 'success';
            $message = 'Your password successfully recovered';

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $password = Yii::$app->request->post('ResetForm')['password'];
                $userModel->password = Yii::$app->getSecurity()->generatePasswordHash($password);
                $userModel->save();

                $tokenModel->delete();

                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                $status = 'danger';
                $message = 'Something went wrong';
            }

            Yii::$app->session->setFlash('status', $status);
            Yii::$app->session->setFlash('message', $message);

            return $this->redirect(['login']);
        }

        return $this->render('reset', [
            'model' => $model,
        ]);
    }
}
