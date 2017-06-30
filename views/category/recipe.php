<?php
/* @var $this yii\web\View */
/* @var $recipes yii\db\ActiveRecord */
/* @var $pagination yii\data\Pagination */
/* @var $category app\models\Category */

use yii\helpers\Url;
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

    <div class="recipe-category-banner"
         style="background: url('<?= Url::to('/img/categories/' . $category->feature) ?>') center center / cover">

        <div class="category-control">
            <p>Follow to get the latest <?= $category->category ?> recipes, articles and more!</p>
            <button class="btn btn-primary category-button-follow">
                <i class="fa fa-plus"></i> Follow
            </button>
        </div>

        <div class="category-content">
            <h1 class="category-title"><?= $category->category ?></h1>
            <p class="category-description"><?= $category->description ?></p>
            <ul class="category-stats list-inline">
                <li><strong><?= $category->getTotalRecipe() ?></strong> <span>recipes</span></li>
                <li><strong><?= $category->getTotalCooked() ?></strong> <span>cooked</span></li>
                <li><strong><?= $category->getTotalLike() ?></strong> <span>likes</span></li>
                <li><strong><?= $category->getTotalReview() ?></strong> <span>reviews</span></li>
            </ul>
        </div>
    </div>

    <h1 class="lead">
        Recipe Category : <strong><?= $category->category ?></strong>
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