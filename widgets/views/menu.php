<?php
use yii\helpers\Url;

/* @var $categories app\models\Category */
?>
<ul class="dropdown-menu">
    <li class="dropdown-header">Categories</li>
    <li><a href="<?= Url::to('/recipe') ?>"><strong>All Recipes</strong></a></li>
    <li class="divider"></li>
    <?php foreach ($categories as $category): ?>
        <li>
            <a href="<?= Url::to(['category/' . $category->slug]) ?>">
                <?= $category->category ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>