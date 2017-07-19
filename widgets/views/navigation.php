<?php
/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $active boolean */

use yii\helpers\Url;

?>

<div class="account-banner"
     style="background: url('<?= Url::to('/img/covers/' . $user->cover) ?>') center center / cover"></div>
<div class="account-navigation">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-3">

                <?php if (!Yii::$app->user->isGuest && Yii::$app->user->id == $user->id): ?>
                    <a href="<?= Url::toRoute('/settings/profile') ?>"
                       class="btn btn-round btn-primary pull-right navigation-button-control">
                        Edit Profile
                    </a>
                <?php endif; ?>

                <ul class="navigation">
                    <li class="<?= $active == 'recipes' ? 'active' : '' ?>">
                        <a href="<?= Url::to('/' . $user->username) ?>">
                            Recipes
                            <span class="navigation-counter"><?= $user->getRecipes()->count() ?></span>
                        </a>
                    </li>
                    <li class="<?= $active == 'favorites' ? 'active' : '' ?>">
                        <a href="<?= Url::to('/' . $user->username . '/favorites') ?>">
                            Favorites
                            <span class="navigation-counter"><?= $user->getFavorites()->count() ?></span>
                        </a>
                    </li>
                    <li class="<?= $active == 'made' ? 'active' : '' ?>">
                        <a href="<?= Url::to('/' . $user->username . '/made') ?>">
                            I Made It
                            <span class="navigation-counter"><?= $user->getCooks()->count() ?></span>
                        </a>
                    </li>
                    <li class="<?= $active == 'following' ? 'active' : '' ?>">
                        <a href="<?= Url::to('/' . $user->username . '/following') ?>">
                            Following
                            <span class="navigation-counter"><?= $user->getFollowings()->count() ?></span>
                        </a>
                    </li>
                    <li class="<?= $active == 'followers' ? 'active' : '' ?>">
                        <a href="<?= Url::to('/' . $user->username . '/followers') ?>">
                            Followers
                            <span class="navigation-counter"><?= $user->getFollowers()->count() ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>