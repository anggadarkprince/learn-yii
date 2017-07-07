<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Cooking - Yummy';
?>

<?php $this->beginBlock('account-banner'); ?>

<div class="blog-banner cooking-banner"
     style="background: url('<?= Url::to('/img/layout/cooking-featured.jpg') ?>') top center / cover">
    <div class="banner-content">
        <h1>Cooking Class</h1>
        <h3>Be a Better Cook</h3>
        <p>
            <small>
                At Yummy, we have the amazing privilege of being a part of the world’s biggest food community. The
                staff at Yummy created this blog so we can share with you the trends, insights, and ideas we come across
                every
                day.
            </small>
        </p>
        <a class="btn btn-lg btn-primary" href="<?= Url::to('/cooking/course') ?>">
            VIEW ALL COURSES
        </a>
    </div>
</div>

<?php $this->endBlock(); ?>

<div class="cooking-page-section cooking-video">
    <div class="section-head">
        <h2>Give yourself a lifetime of cooking confidence</h2>
        <p>
            Open up a new, tasty world of food. Take an Yummy Cooking School course and you’ll feel more confident
            every time you cook. You’ll master the ingredients you use every day, and learn pro tips and techniques that
            make cooking easier.
        </p>
        <p class="lead">Start right now—see how Yummy Cooking School will help you be a better cook.</p>
    </div>
    <div class="section-body">
        <iframe src="//www.youtube.com/embed/u18Drti0kW0" allowfullscreen="" width="640" height="360"
                frameborder="0"></iframe>
    </div>
</div>

<div class="cooking-page-section cooking-featured">
    <div class="section-head">
        <h2>Featured Courses</h2>
        <p>Short demonstration videos show you the techniques and teach you the skills you want.</p>
    </div>
    <div class="section-body">
        <div class="row featured-section">
            <div class="col-md-4">
                <img src="https://d33wubrfki0l68.cloudfront.net/img/8141496781dce3ceba752e34c0b521335ea4cf21/photo1.jpg">
                <h3 class="course-title">Cooking Chicken</h3>
                <p class="course-description">
                    This course includes four lessons, teaching fundamental skills for roasting, braising, chicken—all you
                    need to get the best from the bird.
                </p>
                <p class="course-stats">Learned by <strong>245</strong> cookers</p>
            </div>
            <div class="col-md-4">
                <img src="https://d33wubrfki0l68.cloudfront.net/img/107f3eda7312fb4da4062a187c7902b7a4b1bcd9/photo3.jpg">
                <h3 class="course-title">Baking Basics</h3>
                <p class="course-description">
                    This course provides the best of baking, teaching you basic techniques for making pie crusts, quick
                    breads, and double-crusted fruit pies.
                </p>
                <p class="course-stats">Learned by <strong>245</strong> cookers</p>
            </div>
            <div class="col-md-4">
                <img src="https://d33wubrfki0l68.cloudfront.net/img/2dbdf1553c3383841292b4ea1d53aa5eeb2b23b1/photo2.jpg">
                <h3 class="course-title">Perfect Eggs Every Time</h3>
                <p class="course-description">
                    Learn the many methods of cooking eggs: scrambling, frying all the tips
                    you need to get this versatile ingredient right every time.
                </p>
                <p class="course-stats">Learned by <strong>245</strong> cookers</p>
            </div>
        </div>
        <a class="btn btn-lg btn-warning" href="<?= Url::to('/cooking/course') ?>">Explore Courses</a>
    </div>
</div>

<div class="cooking-page-section cooking-pricing">
    <div class="section-head">
        <h2>Explore <strong>Yummy</strong> Cooking School</h2>
        <p class="lead">Affordable Pricing — Two Great Ways to Learn</p>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-6 column">
                <h3>Pay monthly</h3>
                <p class="price">IDR 50K <span>per month</span></p>
                <p>for access to all courses with affordable cost series.</p>
                <button class="btn btn-lg btn-primary">CHOOSE MONTHLY</button>
            </div>
            <div class="col-md-6">
                <h3>Pay for a year</h3>
                <p class="price">IDR 450K <span>per year</span></p>
                <p><strong>Save over 50% each month</strong> when you sign up for a year!</p>
                <button class="btn btn-lg btn-success">CHOOSE YEARLY</button>
            </div>
        </div>
    </div>
</div>