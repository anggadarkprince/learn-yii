<?php
/* @var $recipe app\models\Recipe */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="row thumbnail-recipe-container">

    <?php foreach ($recipes as $recipe): ?>

        <div class="col-md-3 thumbnail-recipe-wrapper">
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
                    <div class="recipe-stars text-danger">
                        <?php $ratings = $recipe->getRatings()->average('rate') ?>
                        <?php $ratingsFloor = floor($ratings) ?>
                        <?php $isEven = $ratingsFloor > 0 ? $ratings - $ratingsFloor > 0.3 : false ?>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= $ratingsFloor): ?>
                                <i class="fa fa-star"></i>
                            <?php elseif ($isEven): ?>
                                <?php $isEven = false ?>
                                <i class="fa fa-star-half-full"></i>
                            <?php else: ?>
                                <i class="fa fa-star-o"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span><?= $ratings > 0 ? number_format($ratings, 1) : 'Unrated' ?></span>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-2">
                            <div class="recipe-avatar img-circle" style="background: url('<?= Url::to('/img/avatars/' . $recipe->user->avatar) ?>') center center / cover"></div>
                        </div>
                        <div class="col-xs-10">
                            <p class="recipe-author">
                                <span class="text-muted">Recipe by</span>
                                <a href="<?= Url::to(['/' . Html::encode($recipe->user->username)]) ?>">
                                    <?= Html::encode($recipe->user->name) ?>
                                </a>
                            </p>
                            <ul class="list-inline recipe-stats">
                                <li>
                                    <i class="fa fa-user-circle text-primary"></i>&nbsp;
                                    <?= $recipe->user->getFollowers()->count() ?>
                                </li>
                                <li>
                                    <i class="fa fa-heart text-danger"></i>&nbsp;
                                    <?= $recipe->getFavoriters()->count() ?>
                                </li>
                                <li>
                                    <i class="fa fa-cutlery text-success"></i>&nbsp;
                                    <?= $recipe->getCookers()->count() ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

</div>