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

$this->title = 'Setting Application - Yummy';

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
                                <h3 class="lead">Application</h3>
                                <p>Account global preferences</p>
                            </div>

                            <?= $this->render('../errors/_general_alert') ?>

                            <?php $form = ActiveForm::begin([
                                'id' => 'setting-application-form'
                            ]); ?>

                            <?= $form->field($user, 'language')->dropDownList([
                                'en' => 'English',
                                'id' => 'Indonesia',
                                'my' => 'Malaysia',
                                'jp' => 'Japan',
                            ])->hint('Interested in helping translate Yummy? Check out the <a href="/translate">Translation Center</a>.') ?>

                            <?= $form->field($user, 'timezone')->dropDownList($zones) ?>

                            <?= $form->field($user, 'country')->dropDownList(
                                Yii::$app->params['countries']
                            )->hint('Select your country. We will give you related recommendation based your place.') ?>

                            <label for="relevant_content" class="control-label">Content</label>
                            <?= $form->field($user, 'relevant_content')->checkbox()
                                ->hint('Feeds you are likely to care about most will show up first in your feed. 
                                <a href="/help">Learn more</a>.') ?>

                            <div class="form-group">
                                <label for="archive" class="control-label">Archive</label>
                                <span class="help-block">
                                    You can request a file containing your information,
                                    starting with your first Feed. A link will be emailed to you when the file is ready to be downloaded.
                                </span>
                                <div>
                                    <a href="#" class="btn btn-default">Request Archive</a>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="archive" class="control-label">Account</label>
                                <span class="help-block">
                                    You suspend your account for 30 days, after that, your account will be deleted forever.
                                </span>
                                <div>
                                    <a href="#">Deactivate my account</a>
                                </div>
                            </div>

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