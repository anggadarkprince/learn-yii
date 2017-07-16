<?php
use app\widgets\AccountNavigationWidget;
use app\widgets\AccountSidebarWidget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $recipe app\models\Recipe */
/* @var $ingredient app\models\Ingredient */
/* @var $direction app\models\Direction */
/* @var $categories [] app\models\Category */
/* @var $tag app\models\Tag */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Edit Recipe - Yummy';
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
                    <h1 class="lead">Edit Recipe</h1>

                    <?= $this->render('../errors/_general_alert') ?>

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
                        ->dropDownList($categories, [
                            'data-placeholder' => 'Select Category'
                        ])
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
                                'max' => 5000,
                                'placeholder' => 'Total calories per serve'
                            ])->hint('Serving size by acquired energy 2000 KCal') ?>
                        </div>
                    </div>

                    <label for="direction">Ingredient</label>
                    <table class="table" id="table-input-ingredient">
                        <thead>
                        <tr>
                            <th width="40" class="text-center">No</th>
                            <th>Ingredient of cooking</th>
                            <th width="100" class="text-center">Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <?= $form->field($ingredient, 'ingredient')->hiddenInput()->label(false) ?>
                    <div class="form-group">
                        <textarea id="ingredient" class="form-control" rows="1" maxlength="100"
                                  placeholder="Ingredient item"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-block" id="button-add-ingredient">
                            ADD INGREDIENT
                        </button>
                    </div>

                    <label for="direction">Direction</label>
                    <table class="table" id="table-input-direction">
                        <thead>
                        <tr>
                            <th width="40" class="text-center">No</th>
                            <th>Direction of cooking</th>
                            <th width="100" class="text-center">Remove</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <?= $form->field($direction, 'direction')->hiddenInput()->label(false) ?>
                    <div class="form-group">
                        <textarea id="direction" class="form-control" rows="2" maxlength="300"
                                  placeholder="Cook tips and short suggestion"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-block" id="button-add-direction">
                            ADD DIRECTION
                        </button>
                    </div>

                    <?= $form->field($recipe, 'tips')->textarea([
                        'rows' => 3,
                        'placeholder' => 'Cook tips and short suggestion'
                    ]) ?>

                    <?= $form->field($recipe, 'privacy', [
                        'inline' => true
                    ])->radioList([
                        'public' => 'Public',
                        'private' => 'Private',
                        'follower' => 'Follower'
                    ]) ?>

                    <?= $form->field($tag, 'tag')->textInput([
                        'placeholder' => 'Recipe tags or keywords',
                        'data-role' => 'tagsinput'
                    ])->label('Tags or Keywords')->hint('Press , or enter to add tag item') ?>

                    <br>

                    <div class="form-group">
                        <?= Html::submitButton('Update Recipe', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
