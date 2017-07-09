<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Discovery - Yummy';
?>
<div class="discovery-section"
     style="background: url('<?= Url::to('/img/layout/discovery/discovery-recipe.jpg') ?>') top center / cover">
    <div class="container">
        <div class="discovery-content">
            <p class="discovery-subtitle">Popular Recipes</p>
            <h1 class="discovery-title">Featured Food and Recipes.</h1>

            <div class="row card-recipe-container">

                <?php foreach ($recipes as $recipe): ?>

                    <?= $this->render('../recipe/_card_thumbnail', [
                        'recipe' => $recipe,
                        'columns' => 4
                    ]) ?>

                <?php endforeach; ?>

            </div>

            <div class="row discovery-footer">
                <div class="col-md-8">
                    <h4>Delicious and Yummy</h4>
                    <p>Want to eat more veggies, fruit, water or fish? How about eating less red meat?</p>
                </div>
                <div class="col-md-4 footer-button">
                    <a class="btn btn-lg btn-primary" href="<?= Url::toRoute(['diet/program']) ?>">
                        DISCOVER MORE
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="discovery-section"
     style="background: url('<?= Url::to('/img/layout/discovery/discovery-diet.jpg') ?>') top center / cover">
    <div class="container">
        <div class="discovery-content">
            <p class="discovery-subtitle">Diet Program</p>
            <h1 class="discovery-title">Healthy and Happy Life.</h1>

            <div class="row card-diet-container">

                <div class="col-md-3 col-sm-6 card-diet-wrapper">
                    <div class="card-diet">
                        <div class="diet-feature"
                             style="background: url('<?= Url::to('/img/layout/diet/program/program-1.jpg') ?>') center center / cover"></div>
                        <div class="diet-content">
                            <h3 class="diet-title">Weight Gain</h3>
                            <p class="diet-description">Turn skinny body into heavy and healthy ideal weight</p>
                            <hr>
                            <button class="btn btn-round btn-block btn-default">GET STARTER</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 card-diet-wrapper">
                    <div class="card-diet">
                        <div class="diet-feature"
                             style="background: url('<?= Url::to('/img/layout/diet/program/program-2.jpg') ?>') center center / cover"></div>
                        <div class="diet-content">
                            <h3 class="diet-title">Loss Weight</h3>
                            <p class="diet-description">Eat much and keep loss your weight each week</p>
                            <hr>
                            <button class="btn btn-round btn-block btn-default">GET STARTER</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 card-diet-wrapper">
                    <div class="card-diet">
                        <div class="diet-feature"
                             style="background: url('<?= Url::to('/img/layout/diet/program/program-3.jpg') ?>') center center / cover"></div>
                        <div class="diet-content">
                            <h3 class="diet-title">Build Muscle</h3>
                            <p class="diet-description">Make your body pure abs and strong like professional</p>
                            <hr>
                            <button class="btn btn-round btn-block btn-default">GET STARTER</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 card-diet-wrapper">
                    <div class="card-diet">
                        <div class="diet-feature"
                             style="background: url('<?= Url::to('/img/layout/diet/program/program-4.jpg') ?>') center center / cover"></div>
                        <div class="diet-content">
                            <h3 class="diet-title">Healthy Daily</h3>
                            <p class="diet-description">Keep your meal and nutrition stable for healthy life</p>
                            <hr>
                            <button class="btn btn-round btn-block btn-default">GET STARTER</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row discovery-footer">
                <div class="col-md-8">
                    <h4>Diet and Workout</h4>
                    <p>Lose weight. Bulk up. Eat better. Make it happen with Yummy Diet.</p>
                </div>
                <div class="col-md-4 footer-button">
                    <a class="btn btn-lg btn-primary" href="<?= Url::toRoute(['diet/program']) ?>">
                        DISCOVER MORE
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="discovery-section"
     style="background: url('<?= Url::to('/img/layout/discovery/discovery-user.jpg') ?>') top center / cover">
    <div class="container">
        <div class="discovery-content">
            <p class="discovery-subtitle">More People</p>
            <h1 class="discovery-title">Find your friends.</h1>

            <div class="row card-user-container">

                <?php foreach ($users as $user): ?>

                    <?= $this->render('../user/_card_default', [
                        'user' => $user,
                        'columns' => 4
                    ]) ?>

                <?php endforeach; ?>

            </div>

            <div class="row discovery-footer">
                <div class="col-md-8">
                    <h4>Yummy's World United</h4>
                    <p> Find your Yummy friends to share tips and stay inspired on your health journey!.</p>
                </div>
                <div class="col-md-4 footer-button">
                    <a class="btn btn-lg btn-primary" href="<?= Url::toRoute(['diet/program']) ?>">
                        DISCOVER MORE
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
