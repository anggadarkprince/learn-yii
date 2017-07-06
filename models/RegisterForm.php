<?php
/**
 * Created by PhpStorm.
 * User: angga
 * Date: 06/07/17
 * Time: 19:51
 */

namespace app\models;


use yii\base\Model;

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
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            ['status', 'default', 'value' => 'pending'],
        ];
    }
}