<?php
use yii\helpers\Url;

/* @var $categories app\models\Category */
?>
<ul class="dropdown-menu">
    <li><a href="<?= Url::to('/recipe') ?>">All Recipes</a></li>
    <?php foreach ($categories as $category): ?>
        <li>
            <a href="<?= Url::to(['category/' . $category->slug]) ?>">
                <?= $category->category ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>