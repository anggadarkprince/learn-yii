<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'Create Category - Yummy';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['/category']];
$this->params['breadcrumbs'][] = 'Create Category';
?>
<div class="category-create">

    <h1 class="lead">Create New Category</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
