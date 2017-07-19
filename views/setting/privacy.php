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

$this->title = 'Setting Privacy - Yummy';

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

                            <?= $this->render('../errors/_general_alert') ?>

                            <div class="form-title">
                                <h3 class="lead">Privacy</h3>
                                <p>Global personal information protection and recipe</p>
                            </div>

                            <?php $form = ActiveForm::begin([
                                'id' => 'setting-privacy-form'
                            ]); ?>

                            <label for="email_product_offer" class="control-label">Safety</label>
                            <?= $form->field($user, 'private_account')->checkbox()
                                ->label('Protect my account')
                                ->hint('Your account is private, all information and recipe are hidden but discoverable.') ?>
                            <?= $form->field($user, 'private_recipe')->checkbox()
                                ->label('Protect my recipe')
                                ->hint('Your recipes are hidden but your account and information are searchable.') ?>

                            <label class="control-label">Discovery</label>
                            <?= $form->field($user, 'tag_location')->checkbox()
                                ->label('Show location where you post a recipe') ?>
                            <?= $form->field($user, 'discoverability')->checkbox()
                                ->label('Your account and recipe discoverable via search and recommendation.') ?>

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