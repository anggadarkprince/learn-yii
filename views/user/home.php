<?php
/* @var $this yii\web\View */
/* @var $pagination \yii\data\Pagination */
/* @var $user app\models\User */
/* @var $stream[] app\models\Recipe */
/* @var $active string */

use app\widgets\AccountSidebarWidget;
use yii\helpers\Url;

$this->title = $user->name . ' (' . $user->username . ') - Yummy';

?>

<div class="row account-wrapper home-stream">
    <div class="col-md-3">
        <?= AccountSidebarWidget::widget(['user' => $user]) ?>
    </div>
    <div class="col-md-9">
        <div class="account-content">

            <div class="row card-recipe-container">

                <?php foreach ($stream as $recipe): ?>

                    <?= $this->render('../recipe/_card_default', [
                        'recipe' => $recipe,
                        'columns' => 3,
                    ]) ?>

                <?php endforeach; ?>

            </div>

        </div>
    </div>
</div>