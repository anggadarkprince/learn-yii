<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Explore Recipe - Yummy';
$this->registerMetaTag(['name' => 'keywords', 'content' => 'recipe, delicious, yummy, food, beverage, coffee']);
$this->registerMetaTag(['name' => 'description', 'content' => 'This website is about recipe around the world.'], 'description');
$this->registerLinkTag([
    'title' => 'Recipe Explore',
    'rel' => 'alternate',
    'type' => 'application/rss+xml',
    'href' => 'http://www.yummy.com/rss.xml/',
]);
$this->params['breadcrumbs'][] = 'Explore Recipes';
?>
    <h1 class="lead">
        Recipes Around The World
        <small class="pull-right" style="margin-top: 10px">
            Found <?= $pagination->totalCount ?> recipes
        </small>
    </h1>

    <div class="row">

        <?php foreach ($recipes as $recipe): ?>

            <div class="col-md-3">
                <div class="thumbnail thumbnail-recipe">
                    <div class="recipe-feature" style="background: url('<?= Url::to('/img/recipes/' . $recipe->feature) ?>') center center / cover"></div>
                    <div class="caption">
                        <a class="recipe-category" href="<?= Url::to(['category/' . Html::encode($recipe->category->slug)]) ?>">
                            <?= Html::encode($recipe->category->category) ?>
                        </a>
                        <h4 class="recipe-title">
                            <a href="<?= Url::to(['recipe/' . Html::encode($recipe->slug)]) ?>">
                                <?= Html::encode($recipe->title) ?>
                            </a>
                        </h4>
                        <p>
                            <?php if (strlen($recipe->description) > 90): ?>
                                <?= Html::encode(substr($recipe->description, 0, 90)) ?>...
                            <?php else: ?>
                                <?= Html::encode($recipe->description) ?>
                            <?php endif; ?>
                        </p>
                        <div class="star-wrapper text-danger">
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                        </div>
                        <hr>
                        <p>
                            <span class="text-muted">Recipe by</span>
                            <a href="<?= Url::to(['/' . Html::encode($recipe->user->username)]) ?>">
                                <?= Html::encode($recipe->user->name) ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

<?= LinkPager::widget(['pagination' => $pagination]) ?>