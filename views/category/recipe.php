<?php
/* @var $this yii\web\View */

use yii\widgets\LinkPager;

$this->title = $category->category . ' - Yummy';
$this->registerMetaTag(['name' => 'keywords', 'content' => 'recipe, delicious, yummy, food, beverage, coffee']);
$this->registerMetaTag(['name' => 'description', 'content' => $category->description], 'description');
$this->registerLinkTag([
    'title' => 'Recipe Explore',
    'rel' => 'alternate',
    'type' => 'application/rss+xml',
    'href' => 'http://www.yummy.com/rss.xml/',
]);
$this->params['breadcrumbs'][] = ['label' => 'Explore Recipes', 'url' => ['/recipe']];
$this->params['breadcrumbs'][] = $category->category;
?>
    <h1 class="lead">
        Recipe Category : <strong><?= $category->category ?></strong>
        <small class="pull-right" style="margin-top: 10px">
            Found <?= $pagination->totalCount ?> recipes
        </small>
    </h1>

    <?= $this->render('../recipe/_card_default', compact('recipes')) ?>

<?= LinkPager::widget(['pagination' => $pagination]) ?>