<?php
/* @var $this yii\web\View */
/* @var $user app\models\User */

use yii\helpers\BaseStringHelper;
use yii\helpers\Url;

$this->title = $user->name . ' (' . $user->username . ') - Yummy';

?>

<?php $this->beginBlock('account-banner'); ?>

<div class="account-banner" style="background: url('<?= Url::to('/img/layout/main-featured.jpg') ?>') top center / cover"></div>
<div class="account-navigation">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-3">
                <button class="btn btn-primary btn-round pull-right navigation-button-follow">FOLLOW</button>
                <ul class="navigation">
                    <li class="active">
                        <a href="<?= Url::to('/'.$user->username) ?>">
                            Recipes
                            <span class="navigation-counter">
                            <?= $user->getRecipes()->count() ?>
                        </span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to('/'.$user->username.'/favorites') ?>">Favorites
                            <span class="navigation-counter"><?= $user->getFavorites()->count() ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to('/'.$user->username.'/made') ?>">I Made It
                            <span class="navigation-counter"><?= $user->getCookeds()->count() ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to('/'.$user->username.'/following') ?>">Following
                            <span class="navigation-counter"><?= $user->getFollowings()->count() ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= Url::to('/'.$user->username.'/followers') ?>">Followers
                            <span class="navigation-counter"><?= $user->getFollowers()->count() ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $this->endBlock(); ?>

<div class="row account-wrapper">
    <div class="col-md-3">
        <div class="account-sidebar">
            <div class="account-header">
                <div class="account-avatar"
                     style="background: url('<?= Url::to('/img/avatars/' . $user->avatar) ?>') center center / cover"></div>
                <h3 class="account-name"><?= $user->name ?></h3>
                <p class="account-username">@<?= $user->username ?></p>
                <p>
                    <?= BaseStringHelper::truncateWords($user->about, 20) ?>
                </p>
                <?php if(BaseStringHelper::countWords($user->about) > 20): ?>
                    <a href="#">Show More</a>
                <?php endif; ?>
            </div>
            <div class="account-body">
                <button class="btn btn-block btn-primary btn-round account-button-follow">
                    FOLLOW ME
                </button>

                <ul class="account-info">
                    <li><i class="fa fa-map-marker"></i><?= $user->location ?></li>
                    <li><i class="fa fa-envelope-o"></i><?= $user->email ?></li>
                    <li><i class="fa fa-calendar-o"></i>Joined <?= (new DateTime($user->created_at))->format('F Y') ?></li>
                    <li><i class="fa fa-phone"></i>Contact <?= $user->contact ?></li>
                </ul>

                <div class="account-section">
                    <h4 class="lead">Followers</h4>
                    <?php if(count($followers) == 0): ?>
                        <span class="text-muted">Have no any followers.</span>
                    <?php else: ?>
                        <?php foreach ($followers as $follower): ?>
                            <a href="<?= Url::to('/'.$follower->username) ?>" class="account-follower-avatar" title="<?= $follower->name ?>"
                                 style="background: url('<?= Url::to('/img/avatars/' . $follower->avatar) ?>') center center / cover"></a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="account-section">
                    <h4 class="lead">Followings</h4>
                    <?php if(count($followings) == 0): ?>
                        <span class="text-muted">No follow any user yet.</span>
                    <?php else: ?>
                        <?php foreach ($followings as $following): ?>
                            <a href="<?= Url::to('/'.$following->username) ?>" class="account-follower-avatar"
                                 style="background: url('<?= Url::to('/img/avatars/' . $following->avatar) ?>') center center / cover"></a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9">

        <div class="account-content">
            <div class="row card-recipe-container">

                <?php foreach ($recipes as $recipe): ?>

                    <?= $this->render('../recipe/_card_default', [
                        'recipe' => $recipe,
                        'columns' => 3
                    ]) ?>

                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>