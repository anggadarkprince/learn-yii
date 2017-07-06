<?php
use yii\helpers\Url;

/* @var $categories app\models\Category */
?>
<ul class="dropdown-menu">
    <li class="dropdown-header">Categories</li>
    <li class="<?= Yii::$app->controller->id == 'recipe' && Yii::$app->controller->action->id == 'index' ? 'active' : '' ?>">
        <a href="<?= Url::to('/recipe') ?>"><strong>All Recipes</strong></a>
    </li>
    <li class="divider"></li>
    <?php foreach ($categories as $slug => $category): ?>
        <?php $active = Yii::$app->request->get('slug', '') == $slug; ?>
        <li class="<?= $active ? 'active' : '' ?>">
            <a href="<?= Url::to(['category/' . $slug]) ?>">
                <?= $category ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>