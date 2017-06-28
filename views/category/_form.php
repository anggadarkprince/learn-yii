<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(['id' => 'category-form']); ?>

    <?= $form->field($model, 'category')->textInput([
        'placeholder' => 'Category title',
        'maxlength' => true
    ]) ?>

    <?= $form->field($model, 'slug')->textInput([
        'placeholder' => 'Category slug title',
        'maxlength' => true
    ]) ?>

    <?= $form->field($model, 'description')->textarea([
        'placeholder' => 'Category short description',
        'maxlength' => true,
        'rows' => 3
    ]) ?>

    <?= $form->field($model, 'feature')->fileInput(['maxlength' => true]) ?>

    <?php
    $listCategory = ['0' => '-- Root Category --'];
    $listCategory = array_merge($listCategory, $model->findCategoryList());
    ?>
    <?= $form->field($model, 'parent')
        ->dropDownList($listCategory)
        ->label('Parent Category') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
            'class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-warning'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
