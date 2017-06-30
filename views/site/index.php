<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Yummy - Number one recipes in the world';
$this->params['banner-class'] = 'banner-featured';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><i class="fa fa-cutlery"></i>&nbsp; Let's get yummy!</h1>

        <p class="lead">
            Find great cooking tips and recipe around the world.<br>
            <small>
                Find and share everyday cooking inspiration on Yummy. Discover recipes, cooks, videos, and how-tos based
                on the food you love and the friends you follow.
            </small>
        </p>

        <p>
            <a class="btn btn-lg btn-primary" href="<?= Url::to(['discovery']) ?>">
                Discover Delicious Recipes
            </a>
        </p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4 feature-section">
                <h3>Trends and Insights</h3>
                <p>
                    At Yummy, we have the amazing thing of being a part of the world’s food community. The
                    staff at Yummy created this blog so we can share with you the trends, insights, and ideas we
                    come across every day.
                </p>
                <a class="btn btn-default" href="<?= Url::to(['/magazine']) ?>">
                    Read Articles <i class="fa fa-arrow-circle-o-right"></i>
                </a>
            </div>
            <div class="col-lg-4 feature-section">
                <h3>Full Support 24/7</h3>
                <p>
                    Yummy’ staff has written and compiled hundreds of helpful articles to inspire you and help you
                    become a confident and successful home cook. You can find this information in many easy ways.
                </p>
                <a class="btn btn-default" href="<?= Url::to(['/contact']) ?>">
                    Contact Us <i class="fa fa-arrow-circle-o-right"></i>
                </a>
            </div>
            <div class="col-lg-4 feature-section">
                <h3>Free Lesson</h3>
                <p>
                    Learn from professional in one place with everything you’ll need for all of the tasty recipes you’ll
                    be making! Yummy is here to help! Now you’ll never be caught without soy sauce again.
                </p>
                <a class="btn btn-default" href="<?= Url::to(['/shop']) ?>">
                    Cooking Now <i class="fa fa-arrow-circle-o-right"></i>
                </a>
            </div>
        </div>

    </div>
</div>
