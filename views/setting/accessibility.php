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

$this->title = 'Setting Accessibility - Yummy';

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
                                <h3 class="lead">Accessibility</h3>
                                <p>User experience operation control</p>
                            </div>

                            <?= $this->render('../errors/_general_alert') ?>

                            <?php $form = ActiveForm::begin([
                                'id' => 'setting-accessibility-form'
                            ]); ?>

                            <label for="login_notification" class="control-label">Light Mode</label>
                            <?= $form->field($user, 'light_mode')->checkbox()->label('Fast browsing mode')
                                ->hint('Using light mode will be lowering image quality may lack user experience but improve load speed in slow internet connection.') ?>

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