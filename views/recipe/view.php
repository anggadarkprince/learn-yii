<?php
/* @var $this yii\web\View */
/* @var $ingredients yii\db\ActiveRecord */
/* @var $directions yii\db\ActiveRecord */
/* @var $ratings yii\db\ActiveRecord */
/* @var $recommendations yii\db\ActiveRecord */

/* @var $recipe app\models\Recipe */
/* @var $review app\models\Rating */
/* @var $ingredient app\models\Ingredient */
/* @var $direction app\models\Direction */

use app\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Html::encode($recipe->title) . ' - Yummy';
//$this->registerMetaTag(['name' => 'keywords', 'content' => implode(',', $recipe->tags)]);
$this->registerMetaTag(['name' => 'description', 'content' => Html::encode($recipe->description)], 'description');
$this->registerLinkTag([
    'title' => Html::encode($recipe->title),
    'rel' => 'alternate',
    'type' => 'application/rss+xml',
    'href' => 'http://www.yummy.com/rss.xml/',
]);
$this->params['breadcrumbs'][] = ['label' => 'Explore Recipes', 'url' => ['/recipe']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($recipe->category->category), 'url' => ['/category/' . Html::encode($recipe->category->slug)]];
$this->params['breadcrumbs'][] = Html::encode($recipe->title);
?>

<div class="row section-recipe">
    <div class="col-sm-9">
        <div class="row recipe-feature-wrapper">
            <div class="col-md-5 text-center">
                <h1 class="recipe-title">
                    <?= Html::encode($recipe->title) ?>
                </h1>
                <div class="recipe-stars">
                    <?= RatingWidget::widget([
                        'ratings' => $recipe->getRatings()->average('rate'),
                        'isStarOnly' => true
                    ]) ?>
                </div>
                <div class="recipe-made-review">
                    <?= $recipe->getCookers()->count() ?> made it
                    &nbsp;<span class="text-muted">-</span>&nbsp;
                    <?= $recipe->getRatings()->count() ?> reviews
                </div>
                <p class="recipe-author">
                    Recipe By
                    <a href="<?= Url::to(['/' . Html::encode($recipe->user->username)]) ?>">
                        <?= Html::encode($recipe->user->name) ?>
                    </a>
                </p>
                <p class="recipe-description"><?= Html::encode($recipe->description) ?></p>
            </div>
            <div class="col-md-7">
                <div class="recipe-feature"
                     style="background: url('<?= Url::to('/img/recipes/' . $recipe->feature) ?>') center center / cover"></div>
            </div>
        </div>
        <div class="btn-group btn-group-justified recipe-control" role="group" aria-label="...">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-lg btn-primary">
                    <i class="fa fa-heart"></i> Favorite
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-lg btn-default">
                    <i class="fa fa-cutlery"></i> I Made It
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-lg btn-default">
                    <i class="fa fa-comments"></i> Rate It
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-lg btn-default">
                    <i class="fa fa-share-alt"></i> Share
                </button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-lg btn-default">
                    <i class="fa fa-print"></i> Print
                </button>
            </div>
        </div>
        <div class="recipe-row">
            <div class="recipe-row-title">
                Ingredients
                <ul class="list-inline pull-right recipe-section-stats">
                    <li>
                        <?php
                        $totalTime = new DateTime($recipe->cook_time);
                        $preparationTime = new DateTime($recipe->preparation_time);
                        $totalTime->add(new DateInterval('PT' . $preparationTime->format('H\Hi\M')));
                        ?>
                        <?= $totalTime->format('H') != '00' ? $totalTime->format('H') . ' hours' : '' ?>
                        <?= $totalTime->format('i') != '00' ? $totalTime->format('i') . ' minutes' : '' ?>
                        <i class="fa fa-clock-o"></i>
                    </li>
                    <li>
                        <?= $recipe->servings ?> Servings
                        <i class="fa fa-pie-chart"></i>
                    </li>
                    <li>
                        <?= $recipe->calories ?> Calories
                        <i class="fa fa-bar-chart"></i>
                    </li>
                </ul>
            </div>
            <div class="recipe-row-body">
                <div class="row">
                    <?php foreach ($ingredients as $ingredient): ?>

                        <div class="col-sm-6 recipe-ingredient">
                            <i class="fa fa-plus-circle"></i> <?= $ingredient->ingredient ?>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="recipe-row">
            <div class="recipe-row-title">
                Directions
                <ul class="list-inline pull-right recipe-section-stats">
                    <li>
                        <span class="text-muted">Preparation</span>
                        <strong>
                            <?= $preparationTime->format('H') != '00' ? $preparationTime->format('H\h') : '' ?>
                            <?= $preparationTime->format('i') != '00' ? $preparationTime->format('i\m') : '' ?>
                        </strong>
                    </li>
                    <li>
                        <span class="text-muted">Cook</span>
                        <?php $cookTime = new DateTime($recipe->cook_time); ?>
                        <strong>
                            <?= $cookTime->format('H') != '00' ? $cookTime->format('H\h') : '' ?>
                            <?= $cookTime->format('i') != '00' ? $cookTime->format('i\m') : '' ?>
                        </strong>
                    </li>
                    <li>
                        <span class="text-muted">Ready In</span>
                        <strong>
                            <?= $totalTime->format('H') != '00' ? $totalTime->format('H\h') : '' ?>
                            <?= $totalTime->format('i') != '00' ? $totalTime->format('i\m') : '' ?>
                        </strong>
                    </li>
                </ul>
            </div>
            <div class="recipe-row-body">
                <?php $no = 1;
                foreach ($directions as $direction): ?>

                    <div class="recipe-direction">
                        <span><?= $no++ ?></span>
                        <p><?= $direction->direction ?></p>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
        <div class="recipe-row">
            <div class="recipe-row-title">
                Tags and Keywords
            </div>
            <div class="recipe-row-body">
                <ul class="list-inline recipe-tag">
                    <?php foreach ($tags as $tag): ?>

                        <li>
                            <a href="<?= Url::to('/tag/' . $tag->slug) ?>">
                                <h4>
                                    <span class="label label-primary label-lg">
                                        # <?= $tag->tag ?>
                                    </span>
                                </h4>
                            </a>
                        </li>

                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="recipe-row">
            <div class="recipe-row-title">
                Share
            </div>
            <div class="recipe-row-body">
                <ul class="list-inline recipe-share">
                    <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-google"></i></a></li>
                    <li><a href="#"><i class="fa fa-envelope"></i></a></li>
                    <li><a href="#"><i class="fa fa-copy"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="recipe-row">
            <div class="recipe-row-title">
                Reviews
            </div>
            <div class="recipe-row-body">
                <?= $this->render('_review', [
                    'recipe' => $recipe,
                    'ratings' => $ratings,
                ]) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="recipe-row" style="margin-top: 0">
            <div class="recipe-row-title">
                Recommended for you
            </div>
            <div class="recipe-row-body">

                <div class="row card-recipe-container">

                    <?php foreach ($recommendations as $recipe): ?>

                        <?= $this->render('_card_thumbnail', [
                            'recipe' => $recipe,
                            'columns' => 1
                        ]) ?>

                    <?php endforeach; ?>

                </div>

            </div>
        </div>
    </div>
</div>
