<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;

class RegisterForm extends Model
{
    public $name;
    public $email;
    public $username;
    public $password;
    public $confirm_password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'username', 'password', 'confirm_password'], 'required'],
            [['name', 'username', 'password'], 'string', 'max' => 50],
            ['email', 'email'],
            ['username', 'match', 'pattern' => '/^[A-Za-z0-9_-]{3,15}$/', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => ['username'], 'message' => 'Username must be unique.'],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => ['email'], 'message' => 'Email must be unique.'],
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email Address',
            'confirm_password' => 'Confirm Password'
        ];
    }

    /**
     * Send user activation email.
     * @param User $user
     * @param $token
     */
    public function sendActivationEmail(User $user, $token)
    {
        $urlActivation = Url::toRoute(['auth/activate', 'token' => $token], true);

        $message = Yii::$app->mailer->compose('activation', [
            'user' => $user,
            'urlActivation' => $urlActivation
        ]);
        $message->setTo([$user->email => $user->name])
            ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->name])
            ->setSubject('User account activation')
            ->setTextBody('Activate your account by visiting url ' . $urlActivation)
            ->send();
    }

}