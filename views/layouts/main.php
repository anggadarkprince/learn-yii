<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AxiosAsset;
use app\assets\QsAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\FontAwesomeAsset;

AppAsset::register($this);
FontAwesomeAsset::register($this);
AxiosAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="url" content="<?= Url::home(true) ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap <?= isset($this->params['banner-class']) ? $this->params['banner-class'] : '' ?>">

    <?= $this->render('_navigation') ?>

    <?php if (isset($this->blocks['account-banner'])): ?>
        <?= $this->blocks['account-banner'] ?>
    <?php endif; ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer <?= isset($this->params['banner-class']) ? 'transparent' : '' ?>">
    <div class="container">
        <p class="pull-left">&copy; <a href="<?= Url::toRoute(['about']) ?>">Yummy</a> - Recipes around the
            world <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
