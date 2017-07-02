<?php
/* @var $this yii\web\View */
/* @var $articles yii\db\ActiveRecord */
/* @var $article app\models\Article */
/* @var $tag app\models\Tag */
/* @var $pagination yii\data\Pagination */

use app\widgets\BlogSidebarWidget;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Blog tag ' . $tag->tag . ' - Yummy';
$this->registerMetaTag(['name' => 'keywords', 'content' => 'article, magazine, post, blog, recipe, delicious, yummy, food, beverage, coffee']);
$this->registerMetaTag(['name' => 'description', 'content' => 'This website is about recipe around the world.'], 'description');
$this->registerLinkTag([
    'title' => 'Blog Yummy',
    'rel' => 'alternate',
    'type' => 'application/rss+xml',
    'href' => 'http://www.yummy.com/rss.xml/',
]);
?>

<?php $this->beginBlock('account-banner'); ?>

<div class="blog-banner blog-banner-category"
     style="background: url('<?= Url::to('/img/layout/blog-featured.jpg') ?>') top center / cover">
    <div class="banner-content">
        <h1>Tag #<?= $tag->tag ?></h1>
        <p>Food trends and insights</p>
    </div>
</div>

<?php $this->endBlock(); ?>

<div class="row">
    <div class="col-md-8">
        <div class="row">
            <?php foreach ($articles as $article): ?>
                <?= $this->render('../article/_card_default', [
                    'article' => $article,
                    'columns' => 1
                ]) ?>
            <?php endforeach; ?>
        </div>
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
    <div class="col-md-4 col-lg-3 col-lg-offset-1">
        <?= BlogSidebarWidget::widget() ?>
    </div>
</div>
