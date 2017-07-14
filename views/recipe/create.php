<?php
use app\widgets\AccountNavigationWidget;
use app\widgets\AccountSidebarWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $recipe app\models\Recipe */
/* @var $ingredient app\models\Ingredient */
/* @var $direction app\models\Direction */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create Recipe - Yummy';
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
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h1 class="lead">Create New Recipe</h1>

                    <?php $form = ActiveForm::begin([
                        'id' => 'recipe-form'
                    ]); ?>

                    <?= Html::hiddenInput('user_id', Yii::$app->user->identity->getId()) ?>

                    <?= $form->field($recipe, 'title')->textInput([
                        'placeholder' => 'Recipe title',
                        'data-toggle' => 'slug',
                        'data-target' => '#recipe-slug'
                    ]) ?>

                    <?= $form->field($recipe, 'slug')->textInput([
                        'placeholder' => 'Recipe slug title'
                    ])->hint('Recipe title string unique ID') ?>

                    <?= $form->field($recipe, 'description')
                        ->textarea([
                            'placeholder' => 'Recipe description',
                            'rows' => 4
                        ]) ?>

                    <?= $form->field($recipe, 'category_id')
                        ->dropDownList($categories)
                        ->label('Category') ?>

                    <?= $form->field($recipe, 'feature')->fileInput([
                        'accept' => 'image/*'
                    ]) ?>

                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($recipe, 'preparation_time')->input('time', [
                                'pattern' => '([01]?[0-9]|2[0-3]):[0-5][0-9]',
                                'placeholder' => 'Preparation for ingredient and stuffs'
                            ])->hint('Preparation time format hh:mm') ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($recipe, 'cook_time')->input('time', [
                                'pattern' => '([01]?[0-9]|2[0-3]):[0-5][0-9]',
                                'placeholder' => 'Cooking time minimum'
                            ])->hint('Cooking time format hh:mm') ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <?= $form->field($recipe, 'servings')->textInput([
                                'type' => 'number',
                                'min' => 1,
                                'placeholder' => 'Total serving'
                            ])->hint('Total portion of cook result') ?>
                        </div>
                        <div class="col-sm-6">
                            <?= $form->field($recipe, 'calories')->textInput([
                                'type' => 'number',
                                'min' => 0,
                                'placeholder' => 'Total calories per serve'
                            ])->hint('Serving size by acquired energy 2000 KCal') ?>
                        </div>
                    </div>

                    <?= $form->field($ingredient, 'ingredient')->textarea([
                        'rows' => 3,
                        'placeholder' => 'Cook tips and short suggestion'
                    ]) ?>

                    <?= $form->field($direction, 'direction')->textarea([
                        'rows' => 3,
                        'placeholder' => 'Cook tips and short suggestion'
                    ]) ?>

                    <?= $form->field($recipe, 'privacy')->radioList([
                        'public' => 'Public',
                        'private' => 'Private',
                        'follower' => 'Follower'
                    ], [
                        'class' => 'radio'
                    ]) ?>

                    <?= $form->field($recipe, 'tips')->textarea([
                        'rows' => 3,
                        'placeholder' => 'Cook tips and short suggestion'
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Create Recipe', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
