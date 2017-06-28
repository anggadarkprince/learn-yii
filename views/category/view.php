<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->category;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['/category']];
$this->params['breadcrumbs'][] = $model->category;
?>
<div class="category-view">

    <h1 class="lead">
        <?= Html::encode($this->title) ?>
        <div class="pull-right">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'category',
            'slug',
            'description',
            'feature',
            'parent',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
