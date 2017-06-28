<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Explore Recipe - Yummy';
$this->params['breadcrumbs'][] = 'Explore Recipes';
?>
    <h1 class="lead">
        Recipes Around The World
        <small class="pull-right" style="margin-top: 10px">
            Found <?= $pagination->totalCount ?> recipes
        </small>
    </h1>

    <div class="row">

        <?php foreach ($recipes as $recipe): ?>

            <div class="col-md-3">
                <div class="thumbnail" style="min-height: 470px">
                    <div style="height: 200px; background: url('<?= Url::to('/img/recipes/' . $recipe->feature) ?>') center center / cover"></div>
                    <div class="caption">
                        <small class="text-muted">
                            <a href="<?= Url::to(['category/'.$recipe->category->slug]) ?>">
                                <?= $recipe->category->category ?>
                            </a>
                        </small>
                        <h4 style="min-height: 30px">
                            <a href="<?= Url::to(['recipe/' . $recipe->slug]) ?>"><?= $recipe->title ?></a>
                        </h4>
                        <p><?= substr($recipe->description, 0, 90) ?>...</p>
                        <div class="star-wrapper text-danger">
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                            <i class="glyphicon glyphicon-star-empty"></i>
                        </div>
                        <hr>
                        <p>
                            <span class="text-muted">Recipe by</span>
                            <a href="<?= Url::to(['/' . $recipe->user->username]) ?>">
                                <?= $recipe->user->name ?>
                            </a>
                        </p>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

<?= LinkPager::widget(['pagination' => $pagination]) ?>