<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Register - Yummy';
$this->params['banner-class'] = 'banner-featured banner-register';
?>
<div class="site-login">
    <div class="row">
        <div class="col-md-4">
            <h1 class="lead">Join Yummy with Existing Email</h1>

            <?= $this->render('../errors/_general_alert') ?>

            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
            ]); ?>

            <?= $form->field($model, 'name')->textInput([
                'placeholder' => 'Your name'
            ]) ?>

            <?= $form->field($model, 'username')->textInput([
                'placeholder' => 'Put username'
            ]) ?>

            <?= $form->field($model, 'email')->textInput([
                'placeholder' => 'Email address'
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'placeholder' => 'Password'
            ]) ?>

            <?= $form->field($model, 'confirm_password')->passwordInput([
                'placeholder' => 'Confirm password'
            ]) ?>

            <p class="small">
                By registering your account, you are agreeing to our <a href="<?= Url::to('/legal/terms-of-service') ?>">Terms of
                    Service</a> and our <a href="<?= Url::to('/legal/privacy') ?>">Privacy Policy Rights</a>.
            </p>

            <div class="form-group">
                <?= Html::submitButton('Register', [
                    'class' => 'btn btn-primary btn-block btn-lg',
                    'name' => 'register-button'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div class="col-md-8 col-lg-offset-1 col-lg-7">
            <div class="promotion">
                <h1>Yummy,
                    <small>where delicious recipe come from.</small>
                </h1>
                <p>
                    Yummy uses the recipes you save and cooks you follow to suggest great content for you.
                    Join for free! along with people around to make the world sweet and yummy place.
                </p>
            </div>

            <div class="social">
                <p class="lead">Register in with social.</p>
                <p>New and existing Yummy users.</p>
                <button class="btn btn-lg btn-primary btn-social"><i class="fa fa-facebook"></i>Facebook</button>
                <button class="btn btn-lg btn-info btn-social"><i class="fa fa-twitter"></i>Twitter</button>
                <button class="btn btn-lg btn-danger btn-social"><i class="fa fa-google"></i>Google</button>

            </div>
            <p>
                Or <a href="<?= Url::to('/auth/register') ?>">Login with existing account?</a>
            </p>
        </div>
    </div>
</div>
