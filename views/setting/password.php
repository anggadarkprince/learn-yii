<?php
/* @var $this yii\web\View */
/* @var $pagination \yii\data\Pagination */
/* @var $user app\models\User */
/* @var $recipes [] app\models\Recipe */
/* @var $active string */

use app\widgets\AccountNavigationWidget;
use app\widgets\AccountSidebarWidget;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\Url;

$this->title = 'Setting Password - Yummy';

?>

<?php $this->beginBlock('account-banner'); ?>
<?= AccountNavigationWidget::widget(['user' => $user]) ?>
<?php $this->endBlock(); ?>

<div class="row account-wrapper">
    <div class="col-md-3">
        <?= AccountSidebarWidget::widget(['user' => $user]) ?>
    </div>
    <div class="col-md-9">
        <div class="account-content">

            <div class="row setting-content">
                <div class="col-md-10 col-lg-offset-1">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $this->render('_navigation', ['user' => $user]) ?>
                        </div>
                        <div class="col-md-8">

                            <div class="form-title">
                                <h3 class="lead">Password</h3>
                                <p>Change your password or recover your current one.</p>
                            </div>

                            <?= $this->render('../errors/_general_alert') ?>

                            <?php $form = ActiveForm::begin([
                                'id' => 'setting-password-form',
                            ]); ?>

                            <?= $form->field($user, 'old_password')->input('password', [
                                'value' => '',
                                'placeholder' => 'Your current password'
                            ])->hint('<a href="' . Url::toRoute('/auth/forgot?email=' . $user->email) . '">Forgot Password?</a>') ?>

                            <?= $form->field($user, 'new_password')->input('password', [
                                'placeholder' => 'New password'
                            ])->label('New Password') ?>

                            <?= $form->field($user, 'confirm_password')->input('password', [
                                'placeholder' => 'Confirm new password'
                            ])->label('Confirm Password') ?>

                            <hr>

                            <div class="form-group">
                                <?= Html::submitButton('Save Changes', ['class' => 'btn btn-primary']) ?>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>