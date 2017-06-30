<?php
/* @var $this yii\web\View */
/* @var $user app\models\User */

use app\widgets\AccountNavigationWidget;
use app\widgets\AccountSidebarWidget;
use yii\widgets\LinkPager;

$this->title = $user->name . ' (' . $user->username . ') Favorite - Yummy';

?>

<?php $this->beginBlock('account-banner'); ?>
<?= AccountNavigationWidget::widget(['user' => $user, 'active' => $active]) ?>
<?php $this->endBlock(); ?>

<div class="row account-wrapper">
    <div class="col-md-3">
        <?= AccountSidebarWidget::widget(['user' => $user]) ?>
    </div>
    <div class="col-md-9">
        <div class="account-content">
            <div class="row card-recipe-container">

                <?php foreach ($users as $user): ?>

                    <?= $this->render('_card_default', [
                        'user' => $user,
                        'columns' => 3
                    ]) ?>

                <?php endforeach; ?>

            </div>

            <?= LinkPager::widget(['pagination' => $pagination]) ?>
        </div>
    </div>
</div>