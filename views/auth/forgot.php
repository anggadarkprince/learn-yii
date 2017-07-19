<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Forgot Password - Yummy';
$this->params['banner-class'] = 'banner-featured banner-login';
?>
<div class="site-login">
    <div class="row">
        <div class="col-md-4">
            <h1 class="lead">Forgot Password</h1>

            <p>Fill out the following email to recover your account</p>

            <?= $this->render('../errors/_general_alert') ?>

            <?php $form = ActiveForm::begin([
                'id' => 'forgot-form',
            ]); ?>

            <?= $form->field($model, 'email')->textInput([
                'placeholder' => 'Registered email address',
                'value' => Yii::$app->request->get('email')
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Reset Password', [
                    'class' => 'btn btn-primary btn-block btn-lg',
                    'name' => 'forgot-button'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <p class="small">
                Remember you credentials? <a href="<?= Url::toRoute(['auth/login']) ?>">Login Here</a>.
                <br>
                Or <a href="<?= Url::to('/auth/register') ?>">Register new account?</a>
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
        </div>
    </div>
</div>
