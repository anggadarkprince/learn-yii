<?php

/* @var $this yii\web\View */
/* @var $user app\models\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Account Registered - Yummy';
$this->params['banner-class'] = 'banner-featured banner-login';
?>
<div class="site-login">
    <div class="row">
        <div class="col-md-7">
            <div class="promotion">
                <?php $resend = isset($_GET['resend']) ?>
                <h1><?= $resend ? 'Activation Resent' : 'Almost There' ?>,
                    <small>activate your account via email <a href="<?= $user->email ?>"><?= $user->email ?></a>.
                    </small>
                </h1>
                <p>
                    If <?= $user->email ?> is not your email address, please go back and enter the correct one. If you
                    have not receive our email in 15 minutes, please check your spam folder. Still can't find it? try
                    searching email for in:all subject (Yummy user activation)
                </p>
                <p class="lead">
                    <?= $resend ? 'Still did' : 'Did' ?>
                    not receive the email?
                </p>
                <form method="post" action="<?= Url::to(['account/registered', 'token' => $token, 'resend' => true])?>">
                    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>">
                    <button class="btn btn-lg btn-primary btn-social">Resend Activation Email</button>
                </form>
            </div>
        </div>
        <div class="col-md-push-1 col-md-4">
            <h1 class="lead">Sign In With Activated Email</h1>

            <p>Please fill out the following fields to login</p>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'action' => Url::toRoute('account/login')
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
                    'class' => 'btn btn-primary btn-block btn-lg',
                    'name' => 'login-button'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <p class="small">
                By signing in, you are agreeing to our <a href="<?= Url::to('/legal/terms-of-service') ?>">Terms of
                    Service</a> and our <a href="<?= Url::to('/legal/privacy') ?>">Privacy Policy Rights</a>.
            </p>
        </div>
    </div>

</div>
