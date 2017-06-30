<?php
/* @var $this yii\web\View */
/* @var $recipes yii\db\ActiveRecord */
/* @var $pagination yii\data\Pagination */
/* @var $category app\models\Category */

use yii\widgets\LinkPager;

$this->title = $tag->tag . ' - Yummy';
$this->registerMetaTag(['name' => 'keywords', 'content' => 'recipe, delicious, yummy, food, beverage, coffee']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Recipe around the world'], 'description');
$this->registerLinkTag([
    'title' => 'Recipe Explore',
    'rel' => 'alternate',
    'type' => 'application/rss+xml',
    'href' => 'http://www.yummy.com/rss.xml/',
]);
$this->params['breadcrumbs'][] = ['label' => 'Explore Recipes', 'url' => ['/recipe']];
$this->params['breadcrumbs'][] = $tag->tag;
?>

    <h1 class="lead">
        Recipe Tag : <strong><?= $tag->tag ?></strong>
        <small class="pull-right" style="margin-top: 10px">
            Found <?= $pagination->totalCount ?> recipes
        </small>
    </h1>

    <div class="row card-recipe-container">

        <?php foreach ($recipes as $recipe): ?>

            <?= $this->render('../recipe/_card_default', [
                'recipe' => $recipe,
                'columns' => 4
            ]) ?>

        <?php endforeach; ?>

    </div>

<?= LinkPager::widget(['pagination' => $pagination]) ?>