<?php
/* @var $this yii\web\View */
/* @var $recipes yii\db\ActiveRecord */
/* @var $pagination yii\data\Pagination */

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

    <div class="recipe-category-banner"
         style="background: url('<?= Url::to('/img/layout/main-featured.jpg') ?>') center center / cover">

        <div class="category-control">
            <p>New! Personalized suggestion menu and articles</p>
            <button class="btn btn-primary category-button-follow">
                <i class="fa fa-check"></i> Get Recommendation
            </button>
        </div>

        <div class="category-content">
            <h1 class="category-title">Explore Recipes</h1>
            <p class="category-description">
                All recipe around the world. Get recommendations based on your Tastes.
                We move fast, we figure things out as we go, we push hard to create the future.
            </p>
            <ul class="category-stats list-inline">
                <li>
                    Over than <strong><?= number_format(floor($pagination->totalCount / 10) * 10) ?></strong>
                    delicious recipes
                </li>
            </ul>
        </div>
    </div>

    <h1 class="lead">
        Recipes Around The World
        <small class="pull-right" style="margin-top: 10px">
            Found <?= $pagination->totalCount ?> recipes
        </small>
    </h1>

    <div class="row card-recipe-container">

        <?php foreach ($recipes as $recipe): ?>

            <?= $this->render('_card_default', [
                'recipe' => $recipe,
                'columns' => 4
            ]) ?>

        <?php endforeach; ?>

    </div>

<?= LinkPager::widget(['pagination' => $pagination]) ?>