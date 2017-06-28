<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create Recipe - Yummy';
$this->params['breadcrumbs'][] = ['label' => 'Explore Recipes', 'url' => ['/recipe']];
$this->params['breadcrumbs'][] = 'Create New Recipe';
?>

    <h1 class="lead">Create Recipe</h1>

<?php $form = ActiveForm::begin(['id' => 'recipe-form']); ?>

<?= Html::hiddenInput('user_id', Yii::$app->user->identity->getId()) ?>

<?= $form->field($model, 'title')->textInput([
    'autofocus' => true,
    'placeholder' => 'Recipe title'
]) ?>

<?= $form->field($model, 'slug')->textInput([
    'placeholder' => 'Recipe slug title'
])->hint('Recipe title string unique ID') ?>

<?= $form->field($model, 'description')
    ->textarea([
        'placeholder' => 'Recipe description',
        'rows' => 4
    ]) ?>

<?= $form->field($model, 'category_id')
    ->dropDownList($categories)
    ->label('Category') ?>

<?= $form->field($model, 'preparation_time')->input('time', [
    'pattern' => '/[0-9]{2}:[0-9]{2}:[0-9]{2}/',
    'placeholder' => 'Preparation for ingredient and stuffs'
])->hint('Preparation time format hh:mm:ss') ?>

<?= $form->field($model, 'cook_time')->input('time', [
    'pattern' => '/[0-9]{2}:[0-9]{2}:[0-9]{2}/',
    'placeholder' => 'Cooking time minimum'
])->hint('Cooking time format hh:mm:ss') ?>

<?= $form->field($model, 'servings')->textInput([
    'type' => 'number',
    'min' => 1,
    'placeholder' => 'Total serving'
]) ?>

<?= $form->field($model, 'calories')->textInput([
    'type' => 'number',
    'min' => 0,
    'placeholder' => 'Total calories per serve'
])->hint('Serving size by acquired energy 2000 kcal') ?>

<?= $form->field($model, 'privacy')->radioList([
    'public' => 'Public',
    'private' => 'Private',
    'follower' => 'Follower'
]) ?>

<?= $form->field($model, 'tips')->textarea([
    'rows' => 3,
    'placeholder' => 'Cook tips and short suggestion'
]) ?>

    <div class="form-group">
        <?= Html::submitButton('Create Recipe', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>