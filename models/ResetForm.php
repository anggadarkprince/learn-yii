<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;

/**
 * ResetForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ResetForm extends Model
{
    const SCENARIO_RESET = 'reset';
    const SCENARIO_RECOVERY = 'recovery';

    public $token;
    public $email;
    public $password;
    public $confirm_password;

    public function scenarios()
    {
        return [
            self::SCENARIO_RESET => ['email'],
            self::SCENARIO_RECOVERY => ['token', 'email', 'password', 'confirm_password'],
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['token', 'email', 'password', 'confirm_password'], 'required'],
            ['email', 'email'],
            ['email', 'validateEmail'],
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
     * Validates the email.
     * Make sure the request come from registered email.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByEmail($this->email);

            if (is_null($user)) {
                $this->addError($attribute, 'Email address is not registered.');
            }
        }
    }

    /**
     * Send reset token email.
     * @param User $user
     * @param $token
     */
    public function sendResetEmail(User $user, $token)
    {
        $urlReset = Url::toRoute(['auth/reset', 'token' => $token], true);

        $message = Yii::$app->mailer->compose('reset', [
            'user' => $user,
            'urlReset' => $urlReset
        ]);
        $message->setTo([$user->email => $user->name])
            ->setFrom([Yii::$app->params['noReplyEmail'] => Yii::$app->name])
            ->setSubject('Password reset link')
            ->setTextBody('Reset your password by visiting url ' . $urlReset)
            ->send();
    }

}
