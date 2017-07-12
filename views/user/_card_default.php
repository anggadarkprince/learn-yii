<?php
/* @var $user app\models\User */

use yii\helpers\BaseStringHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$column = isset($columns) ? (12 / $columns) : 12;
$columnSmall = $column < 6 ? $column : 12;
?>
<?php if (!is_null($user)): ?>
    <div class="col-md-<?= $column ?> col-sm-<?= $columnSmall ?> card-user-wrapper">
        <div class="card-user">
            <div class="user-feature"
                 style="background: url('<?= Url::to('/img/covers/' . $user->cover) ?>') center center / cover"></div>
            <div class="user-content">
                <div class="user-avatar"
                     style="background: url('<?= Url::to('/img/avatars/' . $user->avatar) ?>') center center / cover"></div>
                <?php
                $followState = Yii::$app->user->identity->isFollow($user->id);
                $followButton = $followState > 0 ? 'btn-primary' : 'btn-default';
                $followLabel = $followState > 0 ? 'Following' : 'Follow Me';
                ?>
                <button class="btn btn-round <?= $followButton ?> pull-right user-button-follow"
                        data-state="<?= $followState ?>"
                        data-id="<?= $user->id ?>"
                        data-toggle="follow">
                    <?= $followLabel ?>
                </button>
                <h3 class="user-name"><a href="<?= Url::to('/'.$user->username) ?>"><?= $user->name ?></a></h3>
                <p class="user-username">@<?= $user->username ?></p>
                <p><?= BaseStringHelper::truncateWords($user->about, 18) ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>