<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Url;

$this->title = 'Contact - Yummy';
$this->params['breadcrumbs'][] = 'Contact Us';
?>
<div class="site-contact">
    <h1 class="lead">Contact Us</h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                                                                                                    Please configure the
                <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Your full name'
                ]) ?>

                <?= $form->field($model, 'email')->input('email', [
                    'placeholder' => 'Put your email address'
                ]) ?>

                <?= $form->field($model, 'subject')->textInput([
                    'placeholder' => 'Subject'
                ]) ?>

                <?= $form->field($model, 'body')->textarea([
                    'rows' => 5,
                    'placeholder' => 'Put content message'
                ])->label('Message') ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>

            <div class="col-lg-6 col-lg-push-1">
                <h3 class="lead">Headquarter</h3>
                <p>
                    Yummy provide top-rated recipes, party ideas, and
                    cooking tips to inspire you year-round, feel free to get in touch with us.
                </p>
                <p>
                    <strong>Avenue Mile Street 34 LS - East Java, Indonesia</strong><br>
                    Contact: <a href="tel:0004346346234">0004346-346-234</a><br>
                    Email: <a href="mailto:"><?= Yii::$app->params['contactEmail'] ?></a>
                </p>
                <h3 class="lead">Customer Support</h3>
                <p>
                    Our customer service email:<br>
                    <a href="<?= Yii::$app->params['supportEmail'] ?>">
                        <?= Yii::$app->params['supportEmail'] ?>
                    </a>
                </p>
                <p>
                    If you found bug or error please contact:<br>
                    <a href="<?= Yii::$app->params['bugReportEmail'] ?>">
                        <?= Yii::$app->params['bugReportEmail'] ?>
                    </a>
                </p>
                <p>Quick Links</p>
                <ul class="list-inline">
                    <li><a href="<?= Url::home() ?>">Home</a></li>
                    <li><a href="<?= Url::to('/privacy') ?>">Privacy</a></li>
                    <li><a href="<?= Url::to('/tos') ?>">Term of Service</a></li>
                    <li><a href="<?= Url::to('/discovery') ?>">Discovery</a></li>
                    <li><a href="<?= Url::to('/about') ?>">About</a></li>
                </ul>
            </div>
        </div>

    <?php endif; ?>
</div>
