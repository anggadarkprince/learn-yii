<?php
/* @var $ratings yii\db\ActiveRecord */

/* @var $recipe app\models\Recipe */
/* @var $review app\models\Rating */

use app\widgets\RatingWidget;
use yii\helpers\Url;

?>
<div class="recipe-review-user">
    <div class="row">
        <div class="col-xs-3 col-md-1">
            <div class="review-avatar img-circle"
                 style="background: url('<?= Url::to('/img/avatars/noavatar.jpg') ?>') center center / cover"></div>
        </div>
        <div class="col-xs-9 col-md-11">
            <a href="<?= Url::to('account/login') ?>" class="btn btn-lg btn-warning review-button-rate">
                Rate and Review
            </a>
        </div>
    </div>
</div>

<hr>

<div class="row recipe-review-feature">
    <div class="col-md-4 review-feature-positive">
        <p class="review-feature-title"><strong>Most positive review</strong></p>

        <div class="row">
            <?= $this->render('../rating/_card_testimony', [
                'review' => $recipe->getRatingPositive(),
                'columns' => 1
            ]) ?>
        </div>

    </div>
    <div class="col-md-4 review-feature-critical">
        <p class="review-feature-title"><strong>Most critical review</strong></p>

        <div class="row">
            <?= $this->render('../rating/_card_testimony', [
                'review' => $recipe->getRatingCritical(),
                'columns' => 1
            ]) ?>
        </div>

    </div>
    <div class="col-md-4 review-feature-ratings">
        <p class="review-feature-title">
            <strong>
                <?= $recipe->getTotalRating() ?> Reviews and Ratings
            </strong>
        </p>
        <?php for ($rate = 5; $rate > 0; $rate--): ?>
            <div class="row review-rating-stats">
                <div class="col-xs-7">
                    <div class="progress">
                        <?php $ratingPercent = $recipe->getTotalRatingPercentage($rate); ?>
                        <div class="progress-bar" role="progressbar"
                             aria-valuenow="<?= $ratingPercent ?>" aria-valuemin="0" aria-valuemax="100"
                             style="width: <?= $ratingPercent ?>%;">
                            <span class="sr-only"><?= $ratingPercent ?> Rating</span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-5 review-rating-stars">
                    <?= RatingWidget::widget([
                        'ratings' => $rate,
                        'isStarOnly' => true
                    ]) ?>
                </div>
            </div>
        <?php endfor; ?>
    </div>
    <div class="col-xs-12">
        <hr>
    </div>
</div>


<div class="row">

    <?php foreach ($ratings as $review): ?>

        <?= $this->render('../rating/_card_default', [
            'review' => $review,
            'columns' => 3
        ]) ?>

    <?php endforeach; ?>

</div>