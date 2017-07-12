<?php
/* @var $this yii\web\View */
/* @var $user app\models\User */

use yii\helpers\BaseStringHelper;
use yii\helpers\Url;

?>

<div class="account-sidebar">
    <div class="account-header">
        <div class="account-avatar"
             style="background: url('<?= Url::to('/img/avatars/' . $user->avatar) ?>') center center / cover"></div>
        <h3 class="account-name"><?= $user->name ?></h3>
        <p class="account-username">@<?= $user->username ?></p>
        <p><?= BaseStringHelper::truncateWords($user->about, 20) ?></p>
        <?php if (BaseStringHelper::countWords($user->about) > 20): ?>
            <a href="#">Show More</a>
        <?php endif; ?>
    </div>
    <div class="account-body">
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id == $user->id): ?>
            <a href="#" class="btn btn-block btn-primary btn-round account-button-follow">
                MAKE RECIPE
            </a>
        <?php else: ?>
            <?php
            $followState = Yii::$app->user->identity->isFollow($user->id);
            $followButton = $followState > 0 ? 'btn-primary' : 'btn-default';
            $followLabel = $followState > 0 ? 'Following' : 'Follow Me';
            ?>
            <button class="btn btn-block <?= $followButton ?> btn-round account-button-follow"
                    data-state="<?= $followState ?>"
                    data-id="<?= $user->id ?>"
                    data-toggle="follow">
                <?= $followLabel ?>
            </button>
        <?php endif; ?>

        <ul class="account-info">
            <li><i class="fa fa-map-marker"></i><?= is_null($user->location) ? 'No location' : $user->location ?></li>
            <li><i class="fa fa-envelope-o"></i><?= $user->email ?></li>
            <li><i class="fa fa-calendar-o"></i>Joined <?= (new DateTime($user->created_at))->format('F Y') ?></li>
            <li><i class="fa fa-phone"></i><?= is_null($user->contact) ? 'No Contact' : 'Contact ' . $user->contact ?>
            </li>
        </ul>

        <div class="account-section">
            <h4 class="lead">Followers</h4>
            <?php if (count($followers) == 0): ?>
                <span class="text-muted">Have no any followers.</span>
            <?php else: ?>
                <?php foreach ($followers as $follower): ?>
                    <a href="<?= Url::to('/' . $follower->username) ?>" class="account-follower-avatar"
                       title="<?= $follower->name ?>"
                       style="background: url('<?= Url::to('/img/avatars/' . $follower->avatar) ?>') center center / cover"></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="account-section">
            <h4 class="lead">Followings</h4>
            <?php if (count($followings) == 0): ?>
                <span class="text-muted">No follow any user yet.</span>
            <?php else: ?>
                <?php foreach ($followings as $following): ?>
                    <a href="<?= Url::to('/' . $following->username) ?>" class="account-follower-avatar"
                       style="background: url('<?= Url::to('/img/avatars/' . $following->avatar) ?>') center center / cover"></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>