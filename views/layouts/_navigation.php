<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use app\widgets\CategoryMenuWidget;
?>
<nav id="navigation" class="navbar-inverse navbar-fixed-top navbar" role="navigation">
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
                <li class="<?= Yii::$app->controller->id == 'article' ? 'active' : '' ?>">
                    <a href="<?= Url::toRoute(['/blog']) ?>">Blog</a>
                </li>
                <li class="<?= Yii::$app->controller->id == 'cooking' ? 'active' : '' ?>">
                    <a href="<?= Url::toRoute(['/cooking']) ?>">Cooking</a>
                </li>
                <li class="<?= Yii::$app->controller->id == 'diet' ? 'active' : '' ?>">
                    <a href="<?= Url::toRoute(['/diet']) ?>">Diet</a>
                </li>
                <li class="<?= Yii::$app->controller->id == 'discovery' ? 'active' : '' ?>">
                    <a href="<?= Url::toRoute(['/discovery']) ?>">Discovery</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Recipes <b class="caret"></b></a>
                    <?= CategoryMenuWidget::widget() ?>
                </li>
            </ul>

            <?php if (!Yii::$app->user->isGuest): ?>
                <ul class="navbar-nav navbar-right nav">
                    <a href="<?= Url::toRoute(['recipe/create']) ?>" class="navbar-right btn btn-primary navbar-btn">
                        Make Recipe
                    </a>
                </ul>
            <?php endif; ?>
            <ul class="navbar-nav navbar-right nav">
                <?php if (Yii::$app->user->isGuest): ?>
                    <li class="<?= Yii::$app->controller->action->id == 'login' ? 'active' : '' ?>">
                        <a href="<?= Url::toRoute(['auth/login']) ?>">Login</a>
                    </li>
                    <li class="<?= Yii::$app->controller->action->id == 'register' ? 'active' : '' ?>">
                        <a href="<?= Url::toRoute(['auth/register']) ?>">Register</a>
                    </li>
                <?php else: ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user text-muted"></i> &nbsp;
                            <?= Yii::$app->user->identity->name ?> <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?= Url::toRoute(['/'.Yii::$app->user->identity->username]) ?>">
                                    <i class="fa fa-dashboard text-muted"></i> &nbsp; Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute(['account/recipes']) ?>">
                                    <i class="fa fa-cutlery text-muted"></i> &nbsp; Recipes
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::toRoute(['account/setting']) ?>">
                                    <i class="fa fa-cog text-muted"></i> &nbsp; Setting
                                </a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="<?= Url::toRoute(['auth/logout']) ?>">
                                    <i class="fa fa-sign-out text-muted"></i> &nbsp; Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="navbar-right">
                <button class="navbar-button-search"><i class="fa fa-search"></i> Search</button>
                <form class="navbar-form navbar-search" method="get" style="display: none">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Find a recipe" name="q"
                               style="width: 300px; box-shadow: none; border-radius: 2px;">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>
