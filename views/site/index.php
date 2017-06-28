<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Yummy - Number one recipes in the world';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Let's get yummy!</h1>

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
            <div class="col-lg-4">
                <h3>Trends and Insights</h3>
                <p>
                    At Yummy, we have the amazing privilege of being a part of the world’s biggest food community. The
                    staff at Yummy created this blog so we can share with you the trends, insights, and ideas we
                    come across every day.
                </p>
                <p>
                    <a class="btn btn-default" href="<?= Url::to(['blog']) ?>">
                        Read Articles
                    </a>
                </p>
            </div>
            <div class="col-lg-4">
                <h3>Forum Support 24/7</h3>
                <p>
                    Yummy’ staff has written and compiled hundreds of helpful articles to inspire you and help you
                    become a confident and successful home cook. You can find this information in many easy ways.
                </p>
                <p>
                    <a class="btn btn-default" href="<?= Url::to(['forum']) ?>">
                        Ask Forum
                    </a>
                </p>
            </div>
            <div class="col-lg-4">
                <h3>Material Support</h3>
                <p>
                    Create a Shopping List in one place with everything you’ll need for all of the tasty recipes you’ll
                    be making! Yummy is here to help! Now you’ll never be caught without soy sauce again.
                </p>

                <p>
                    <a class="btn btn-default" href="<?= Url::to(['forum']) ?>">
                        Shopping Now
                    </a>
                </p>
            </div>
        </div>

    </div>
</div>
