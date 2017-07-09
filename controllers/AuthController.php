<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\RegisterForm;
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
                if ($user->status == User::$STATUS_PENDING) {
                    $tokenData = $user->getTokens()->where(['type' => UserToken::$TYPE_REGISTRATION])->one();
                    $link = Html::a('click here', Url::toRoute(['auth/registered',
                        'token' => $tokenData['key']
                    ]));
                    Yii::$app->session->setFlash('status', 'danger');
                    Yii::$app->session->setFlash('message', 'Account need activation, ' . $link . ' to resend email confirmation');
                } else if ($user->status == User::$STATUS_SUSPENDED) {
                    Yii::$app->session->setFlash('status', 'danger');
                    Yii::$app->session->setFlash('message', 'Your account was suspended, contact our team support to fix this');
                } else if ($model->login()) {
                    return $this->redirect('/' . Yii::$app->user->identity->username);
                }
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
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
                $user->status = User::$STATUS_PENDING;
                $user->save();

                $token = Yii::$app->getSecurity()->generateRandomString();
                $userToken = new UserToken();
                $userToken->key = $token;
                $userToken->type = UserToken::$TYPE_REGISTRATION;
                $userToken->link('user', $user);

                $transaction->commit();

                $model->sendActivationEmail($user, $token);

                return $this->redirect(Url::toRoute(['auth/registered',
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
    public function actionRegistered($token)
    {
        $tokenData = UserToken::findOne(['key' => $token]);
        if (is_null($tokenData)) {
            throw new HttpException(404, 'Invalid user activation token');
        }

        $userData = $tokenData->user;
        if ($userData->status != User::$STATUS_PENDING) {
            throw new HttpException(400, 'Your account was ' . $userData->status);
        }

        if (Yii::$app->request->isPost) {
            $register = new RegisterForm();
            $register->sendActivationEmail($userData, $token);
        }

        $model = new LoginForm();
        return $this->render('registered', [
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
        if ($userData->status != User::$STATUS_PENDING) {
            throw new HttpException(400, 'Your account was ' . $userData->status);
        }

        // set default flash message
        $status = 'success';
        $message = 'Your account successfully activated';

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // update user status
            $userData->status = User::$STATUS_ACTIVATED;
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
     * Logout action.
     * @return yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
