<?php
/* @var $review app\models\Rating */

use app\widgets\RatingWidget;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

$column = isset($columns) ? (12 / $columns) : 12;
$columnSmall = $column < 6 ? $column : 12;
?>

<?php if(!is_null($review)): ?>
    <div class="col-md-<?= $column ?> col-sm-<?= $columnSmall ?>">
        <div class="recipe-review">
            <div class="review-header">
                <div class="row">
                    <div class="col-xs-3">
                        <div class="review-avatar img-circle"
                             style="background: url('<?= Url::to('/img/avatars/' . $review->user->avatar) ?>') center center / cover"></div>
                    </div>
                    <div class="col-xs-9">
                        <p class="review-author">
                            <a class="link-natural"
                               href="<?= Url::to(['/' . Html::encode($review->user->username)]) ?>">
                                <?= Html::encode($review->user->name) ?>
                            </a>
                        </p>
                        <ul class="list-inline review-stats">
                            <li class="stats-follower">
                                <i class="fa fa-user-circle"></i>
                                <?= $review->user->getFollowers()->count() ?>
                            </li>
                            <li class="stats-favorite">
                                <i class="fa fa-heart"></i>
                                <?= $review->user->getFavorites()->count() ?>
                            </li>
                            <li class="stats-cooked">
                                <i class="fa fa-cutlery"></i>
                                <?= $review->user->getCooks()->count() ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="review-body">
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
                    <?= StringHelper::truncateWords($review->review, 30) ?>
                </p>
                <a href="#readmore" class="review-more">
                    <i class="fa fa-external-link-square"></i> Read More
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>