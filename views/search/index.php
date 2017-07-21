<?php
/* @var $this yii\web\View */
/* @var $query string */
/* @var $filter string */

use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Search ' . $query . ' - Yummy';
?>

<ul class="search-filter">
    <li<?= $filter == 'recipes' ? ' class="active"' : ''?>>
        <a href="<?= Url::to(['/search', 'q' => $query, 'f' => 'recipes']) ?>" class="link-natural">
            Recipes
        </a>
    </li>
    <li<?= $filter == 'people' ? ' class="active"' : ''?>>
        <a href="<?= Url::to(['/search', 'q' => $query, 'f' => 'people']) ?>" class="link-natural">
            People
        </a>
    </li>
    <li<?= $filter == 'articles' ? ' class="active"' : ''?>>
        <a href="<?= Url::to(['/search', 'q' => $query, 'f' => 'articles']) ?>" class="link-natural">
            Articles
        </a>
    </li>
</ul>

<h1 class="lead">
    Search result of "<?= $query ?>"
    <small class="pull-right" style="margin-top: 10px">
        Found <?= $pagination->totalCount ?> <?= $filter ?>
    </small>
</h1>

<?php if ($filter == 'recipes'): ?>

        <div class="row card-recipe-container">
            <?php foreach ($result as $recipe): ?>
                <?= $this->render('../recipe/_card_default', [
                    'recipe' => $recipe,
                    'columns' => 4
                ]) ?>
            <?php endforeach; ?>
        </div>

<?php elseif ($filter == 'people'): ?>

    <div class="row card-recipe-container">
        <?php foreach ($result as $user): ?>
            <?= $this->render('../user/_card_default', [
                'user' => $user,
                'columns' => 4
            ]) ?>
        <?php endforeach; ?>
    </div>

<?php elseif ($filter == 'articles'): ?>

    <div class="row card-article-container">
        <?php foreach ($result as $article): ?>
            <?= $this->render('../article/_card_default', [
                'article' => $article,
                'columns' => 2
            ]) ?>
        <?php endforeach; ?>
    </div>

<?php endif; ?>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
