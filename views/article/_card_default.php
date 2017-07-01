<?php
/* @var $article app\models\Article */
/* @var $columns integer */

use yii\helpers\Url;

$column = isset($columns) ? (12 / $columns) : 12;
$columnSmall = $column < 6 ? $column : 12;
?>

<?php if (!is_null($article)): ?>
    <div class="col-md-<?= $column ?> col-sm-<?= $columnSmall ?>">
        <div class="blog-article">
            <div class="blog-article-header">
                <div class="article-feature"
                     style="background: url('<?= Url::to('/img/blog/' . $article->feature) ?>') center center / cover"></div>
                <h1 class="article-title">
                    <a href="<?= Url::to('/article/' . $article->slug) ?>" class="link-natural">
                        <?= $article->title ?>
                    </a>
                </h1>
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
                <p><?= $article->summary ?></p>
                <a href="<?= Url::to(["blog/article/{$article->slug}"]) ?>">READ MORE</a>
            </div>
        </div>
    </div>
<?php endif; ?>
