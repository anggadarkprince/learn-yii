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

$this->title = 'Setting Security - Yummy';

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
                                <h3 class="lead">Security</h3>
                                <p>User account protection configuration</p>
                            </div>

                            <?= $this->render('../errors/_general_alert') ?>

                            <?php $form = ActiveForm::begin([
                                'id' => 'setting-security-form'
                            ]); ?>

                            <label for="login_notification" class="control-label">Login Notification</label>
                            <?= $form->field($user, 'login_notification')->checkbox()->label('Email login notification')
                                ->hint('You will receive an email to evaluate login behavior that contain location and device that you recognize.') ?>

                            <label for="login_verification" class="control-label">Login Verification</label>
                            <?= $form->field($user, 'login_verification')->checkbox()->label('Verify login request')
                                ->hint('After you log in, Yummy will send a SMS message with a code that you\'ll need to access your account.') ?>

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