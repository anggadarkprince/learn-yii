<?php
/* @var $review app\models\Rating */

use app\widgets\RatingWidget;
use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$column = isset($columns) ? (12 / $columns) : 12;
$columnSmall = $column < 6 ? $column : 12;
?>

<?php if(!is_null($review)): ?>
    <div class="col-md-<?= $column ?> col-sm-<?= $columnSmall ?>">
        <div class="recipe-review">
            <div class="review-body">
                <p class="review-author">
                    <strong>
                        <a class="link-natural"
                           href="<?= Url::to(['/' . Html::encode($review->user->username)]) ?>">
                            <?= Html::encode($review->user->name) ?>
                        </a>
                    </strong>
                </p>
                <div class="review-rating">
                    <?= RatingWidget::widget([
                        'ratings' => $review->rate,
                        'isStarOnly' => true
                    ]) ?>
                    <small class="text-muted pull-right review-date">
                        <?= (new DateTime($review->created_at))->format('d F Y H:i') ?>
                    </small>
                </div>
                <p class="review-content">
                    <?= BaseStringHelper::truncateWords($review->review, 30) ?>
                </p>
                <a href="#readmore" class="review-more">
                    <i class="fa fa-external-link-square"></i> Read More
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>