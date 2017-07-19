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
use yii\widgets\LinkPager;

$this->title = 'Setting Profile - Yummy';

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
                                <h3 class="lead">User Profile</h3>
                                <p>Account profile information</p>
                            </div>

                            <?= $this->render('../errors/_general_alert') ?>

                            <?php $form = ActiveForm::begin([
                                'id' => 'setting-profile-form',
                            ]); ?>

                            <?= $form->field($user, 'name')->textInput([
                                'placeholder' => 'Your name'
                            ]) ?>

                            <?= $form->field($user, 'username')->textInput([
                                'placeholder' => 'Username'
                            ]) ?>

                            <?= $form->field($user, 'email')->input('email', [
                                'placeholder' => 'Email address'
                            ]) ?>

                            <?= $form->field($user, 'avatarImage')->fileInput([
                                'accept' => 'image/*'
                            ]) ?>

                            <?= $form->field($user, 'coverImage')->fileInput([
                                'accept' => 'image/*'
                            ]) ?>

                            <?= $form->field($user, 'location')->textInput([
                                'placeholder' => 'Location'
                            ]) ?>

                            <?= $form->field($user, 'about')->textarea([
                                'rows' => 4,
                                'placeholder' => 'About me'
                            ]) ?>

                            <?= $form->field($user, 'contact')->input('tel', [
                                'placeholder' => 'Contact'
                            ]) ?>

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