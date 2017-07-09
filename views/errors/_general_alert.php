<?php use yii\bootstrap\Alert;

if (Yii::$app->session->hasFlash('status')): ?>
    <?= Alert::widget([
        'options' => ['class' => 'alert-'.Yii::$app->session->getFlash('status')],
        'body' => Yii::$app->session->getFlash('message'),
    ]); ?>
<?php endif;