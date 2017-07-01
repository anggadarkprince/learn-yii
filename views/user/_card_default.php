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
                <button class="btn btn-round btn-primary pull-right user-button-follow">Following</button>
                <h3 class="user-name"><a href="<?= Url::to('/'.$user->username) ?>"><?= $user->name ?></a></h3>
                <p class="user-username">@<?= $user->username ?></p>
                <p><?= BaseStringHelper::truncateWords($user->about, 18) ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>