<?php
/* @var $recipe app\models\Recipe */

use app\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$column = isset($columns) ? (12 / $columns) : 12;
$columnSmall = $column < 6 ? $column : 12;
?>
<?php if (!is_null($recipe)): ?>
    <div class="col-md-<?= $column ?> col-sm-<?= $columnSmall ?> card-recipe-wrapper">
        <div class="thumbnail card-recipe">
            <div class="recipe-feature"
                 style="background: url('<?= Url::to('/img/recipes/' . $recipe->feature) ?>') center center / cover">

                <div class="recipe-control dropdown pull-right">
                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true">
                        ACTION <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li class="dropdown-header">Action</li>
                        <li><a href="javascript:void(0)">Share To</a></li>
                        <li><a href="<?= Url::toRoute('recipe/edit/' . $recipe->slug) ?>">Edit Recipe</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= Url::toRoute('recipe/delete/' . $recipe->slug) ?>">Delete Decipe</a></li>
                    </ul>
                </div>

            </div>
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
                    <?= StringHelper::truncateWords($recipe->description, 14) ?>
                </p>
                <div class="recipe-stars text-danger">
                    <?= RatingWidget::widget([
                        'ratings' => $recipe->getRatings()->average('rate')
                    ]) ?>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-2">
                        <div class="recipe-avatar img-circle"
                             style="background: url('<?= Url::to('/img/avatars/' . $recipe->user->avatar) ?>') center center / cover"></div>
                    </div>
                    <div class="col-xs-10">
                        <p class="recipe-author">
                            <span class="text-muted">Recipe by</span>
                            <a href="<?= Url::to(['/' . Html::encode($recipe->user->username)]) ?>">
                                <?= Html::encode($recipe->user->name) ?>
                            </a>
                        </p>
                        <ul class="list-inline recipe-stats">
                            <li class="stats-follower">
                                <i class="fa fa-user-circle text-primary"></i>&nbsp;
                                <?= $recipe->user->getFollowers()->count() ?>
                            </li>
                            <li class="stats-favorite">
                                <i class="fa fa-heart text-danger"></i>&nbsp;
                                <?= $recipe->user->getFavorites()->count() ?>
                            </li>
                            <li class="stats-cooked">
                                <i class="fa fa-cutlery text-success"></i>&nbsp;
                                <?= $recipe->user->getCooks()->count() ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>