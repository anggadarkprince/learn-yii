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

$this->title = 'Setting Notification - Yummy';

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
                                <h3 class="lead">Notifications</h3>
                                <p>Get email and web notification right away</p>
                            </div>

                            <?php $form = ActiveForm::begin([
                                'id' => 'setting-notification-form'
                            ]); ?>

                            <label for="email_product_offer" class="control-label">Product Offer</label>
                            <?= $form->field($user, 'email_product_offer')->checkbox()
                                ->label('News about Twitter product and feature updates')
                            ->hint('Tips on getting more out of Yummy, info such as news and update on partner products and other third party services  ') ?>

                            <label class="control-label">Recipe Feed</label>
                            <?= $form->field($user, 'email_recipe_feed')->checkbox()->label('Send me update recipe of my following') ?>
                            <?= $form->field($user, 'email_recipe_recommendation')->checkbox()->label('Give me recipe recommendations') ?>

                            <label class="control-label">Interactions</label>
                            <?= $form->field($user, 'email_follower')->checkbox()->label('Let me know if someone follow me') ?>
                            <?= $form->field($user, 'email_message')->checkbox()->label('Send direct message to email') ?>

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