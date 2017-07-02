<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login - Yummy';
$this->params['banner-class'] = 'banner-featured banner-2';
?>
<div class="site-login">
    <div class="row">
        <div class="col-md-4">
            <h1 class="lead">Sign In With Existing Email</h1>

            <p>Please fill out the following fields to login</p>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
            ]); ?>

            <?= $form->field($model, 'username')->textInput([
                'placeholder' => 'Put username or email'
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Password'
            ]) ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Login', [
                    'class' => 'btn btn-primary btn-block',
                    'name' => 'login-button'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <p class="small">
                By signing in, you are agreeing to our <a href="<?= Url::to('/legal/tos') ?>">Terms of
                    Service</a> and our <a href="<?= Url::to('/legal/privacy') ?>">Privacy Policy Rights</a>.
            </p>

        </div>
        <div class="col-md-8 col-lg-offset-1 col-lg-7">
            <div class="promotion">
                <h1>Yummy,
                    <small>where delicious recipe come from.</small>
                </h1>
                <p>Join with us, along people around to make the world sweet and yummy place.</p>
            </div>

            <div class="social">
                <p class="lead">Sign in with social.</p>
                <p>New and existing Yummy users.</p>
                <button class="btn btn-lg btn-primary btn-social"><i class="fa fa-facebook"></i>Facebook</button>
                <button class="btn btn-lg btn-info btn-social"><i class="fa fa-twitter"></i>Twitter</button>
                <button class="btn btn-lg btn-danger btn-social"><i class="fa fa-google"></i>Google</button>

            </div>
            <p>
                Get trouble with login, try <a href="<?= Url::to('/account/forgot') ?>">Forgot Password?</a>
                <br>
                Or <a href="<?= Url::to('/account/register') ?>">Register new account?</a>
            </p>
        </div>
    </div>
</div>
