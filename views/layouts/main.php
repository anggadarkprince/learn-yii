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
    <nav id="navigation" class="navbar-default navbar-fixed-top navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span></button>
                <a class="navbar-brand" href="<?= Url::home() ?>">Yummy</a>
            </div>
            <div id="navigation-collapse" class="collapse navbar-collapse">
                <ul class="navbar-nav nav">
                    <li><a href="<?= Url::to(['/magazine']) ?>">Magazine</a></li>
                    <li><a href="<?= Url::to(['/cooking']) ?>">Cooking</a></li>
                    <li><a href="<?= Url::to(['/discovery']) ?>">Discovery</a></li>
                    <ul class="navbar-nav nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Recipes <b class="caret"></b></a>
                            <?= \app\widgets\CategoryMenuWidget::widget() ?>
                        </li>
                    </ul>
                </ul>
                <form class="navbar-form navbar-left" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Find a recipe" name="q" style="width: 300px; box-shadow: none; border-radius: 2px;">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Search</button>
                        </span>
                    </div>
                </form>

                <a href="<?= Url::to(['recipe/create']) ?>" class="navbar-right btn btn-primary navbar-btn" style="margin: 8px 0 8px 15px">
                    Make Recipe
                </a>
                <ul class="navbar-nav navbar-right nav">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <li><a href="<?= Url::to(['account/login']) ?>">Login</a></li>
                        <li><a href="<?= Url::to(['account/register']) ?>">Register</a></li>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user text-muted"></i> &nbsp;
                                <?= Yii::$app->user->identity->name ?> <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?= Url::to(['account/dashboard']) ?>">
                                        <i class="glyphicon glyphicon-dashboard text-muted"></i> &nbsp; Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['account/recipes']) ?>">
                                        <i class="glyphicon glyphicon-file text-muted"></i> &nbsp; Recipes
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= Url::to(['account/setting']) ?>">
                                        <i class="glyphicon glyphicon-cog text-muted"></i> &nbsp; Setting
                                    </a>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="<?= Url::to(['account/logout']) ?>">
                                        <i class="glyphicon glyphicon-log-out text-muted"></i> &nbsp; Logout
                                    </a>
                                </li>
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
