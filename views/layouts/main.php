<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
    <nav id="w0" class="navbar-default navbar-fixed-top navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></button>
                <a class="navbar-brand" href="<?= Url::home() ?>">Yummy</a>
            </div>
            <div id="w0-collapse" class="collapse navbar-collapse">
                <p class="navbar-text">Recipes around the world</p>
                <ul id="w1" class="navbar-nav navbar-right nav">
                    <form class="navbar-form navbar-left" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search" name="q">
                        </div>
                    </form>
                    <li><a href="<?= Url::to(['discovery']) ?>">Discovery</a></li>
                    <ul id="w1" class="navbar-nav nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Browse <b class="caret"></b></a>
                            <?= \app\widgets\CategoryMenuWidget::widget() ?>
                        </li>
                    </ul>

                    <?php if (Yii::$app->user->isGuest): ?>
                        <li><a href="<?= Url::to(['login']) ?>">Login</a></li>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                Account <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?= Url::to(['account/dashboard']) ?>"><?= Yii::$app->user->identity->name ?></a>
                                </li>
                                <li><a href="<?= Url::to(['account/recipes']) ?>">Recipes</a></li>
                                <li><a href="<?= Url::to(['account/setting']) ?>">Account</a></li>
                                <li><a href="<?= Url::to(['account/logout']) ?>">Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <a href="<?= Url::to(['about']) ?>">Yummy</a> - Recipes around the world <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
