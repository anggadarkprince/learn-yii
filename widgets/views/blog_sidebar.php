<?php
/* @var $this yii\web\View */
/* @var $articles yii\db\ActiveRecord */
/* @var $archives yii\db\ActiveRecord */
/* @var $categories yii\db\ActiveRecord */

/* @var $article app\models\Article */
/* @var $archive app\models\Article */
/* @var $category app\models\Category */

use yii\helpers\Url;

?>
<div class="blog-sidebar">
    <div class="blog-sidebar-section">
        <h3 class="blog-sidebar-title">Recent Post</h3>
        <ul class="blog-sidebar-recent">
            <?php foreach ($articles as $article): ?>
                <li>
                    <a href="<?= Url::to('/article/' . $article->slug) ?>" class="link-natural">
                        <?= $article->title ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="blog-sidebar-section">
        <h3 class="blog-sidebar-title">Archives</h3>
        <ul class="blog-sidebar-recent">
            <?php foreach ($archives as $archive): ?>
                <li>
                    <a href="<?= Url::to('/blog/' . $archive->archiveYear . '/' . $archive->archiveMonth) ?>" class="link-natural">
                        <?= $archive->archiveLabel ?> (<?= $archive->totalArticle ?>)
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="blog-sidebar-section">
        <h3 class="blog-sidebar-title">Categories</h3>
        <ul class="blog-sidebar-recent">
            <?php foreach ($categories as $category): ?>
                <li>
                    <a href="<?= Url::to('/blog/' . $category->slug) ?>" class="link-natural">
                        <?= $category->category ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>