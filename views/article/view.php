<?php
/* @var $this yii\web\View */
/* @var $article app\models\Article */
/* @var $pagination yii\data\Pagination */

use app\widgets\BlogSidebarWidget;
use yii\helpers\Url;

$this->title = $article->title . ' - Yummy';
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

<div class="blog-banner blog-banner-article"
     style="background: url('<?= Url::to('/img/blog/' . $article->feature) ?>') top center / cover">
    <div class="banner-content">
        <h1><?= $article->title ?></h1>
        <p>
            <small>
                <?= $article->excerpt ?>
            </small>
        </p>
        <div class="blog-article">
            <div class="blog-article-header">
                <ul class="article-stats">
                    <li>
                        Written by
                        <a href="<?= Url::to('/' . $article->user->username) ?>">
                            <?= $article->user->name ?>
                        </a>
                    </li>
                    <li><?= $article->publishedAt ?></li>
                    <li>
                        Category
                        <a href="<?= Url::to('/blog/' . $article->category->slug) ?>">
                            <?= $article->category->category ?>
                        </a>
                    </li>
                    <li><?= $article->view ?> views</li>
                </ul>
            </div>
            <div class="blog-article-body">
                <?php foreach ($article->tags as $tag): ?>
                    <a class="label label-outline" href="<?= Url::to('/blog/tag/' . $tag->slug) ?>">
                        # <?= $tag->tag ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php $this->endBlock(); ?>

<div class="row">
    <div class="col-md-8">
        <div class="blog-article">
            <div class="blog-article-body">
                <?= $article->content ?>
            </div>
            <div class="blog-article-footer">
                <p>Last Updated At <strong><?= $article->updatedAt ?></strong></p>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-3 col-lg-offset-1">
        <?= BlogSidebarWidget::widget() ?>
    </div>
</div>
