<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Diet - Yummy';
?>

<?php $this->beginBlock('account-banner'); ?>

<div class="blog-banner diet-banner"
     style="background: url('<?= Url::to('/img/layout/diet-featured.jpg') ?>') top center / cover">
    <div class="banner-content">
        <h1>Healthy living.</h1>
        <h2>Simplified.</h2>
        <p>Lose weight. Bulk up. Eat better. Make it happen with Yummy Diet.</p>
        <a class="btn btn-lg btn-primary" href="<?= Url::toRoute(['diet/program']) ?>">
            LEARN MORE
        </a>
    </div>
</div>

<?php $this->endBlock(); ?>

<div class="row diet-feature-section">
    <div class="col-sm-5">
        <img src="<?= Url::to('/img/layout/diet/diet-1.jpg') ?>" alt="Measure" class="img-responsive">
    </div>
    <div class="col-sm-5 col-sm-offset-1">
        <p class="diet-feature-subtitle">RECIPES</p>
        <h2 class="diet-feature-title">What you measure you can improve</h2>
        <p class="diet-feature-text">
            With Yummy Diet, tracking your healthy habits (and the not so healthy ones) becomes a breeze. We'll help you
            pick the right food, and eat the right portion sizes, to reach your personal health goals.
        </p>
    </div>
</div>

<div class="row diet-feature-section">
    <div class="col-sm-5 col-sm-offset-1">
        <p class="diet-feature-subtitle">PLANS</p>
        <h2 class="diet-feature-title">Pick your diet plan</h2>
        <p class="diet-feature-text">
            From Low Carb to Clean Eating, High Protein and everything in between, we've got what you need. Buon
            appetito!
        </p>
    </div>
    <div class="col-sm-5">
        <img src="<?= Url::to('/img/layout/diet/diet-2.jpg') ?>" alt="Plan" class="img-responsive">
    </div>
</div>

<div class="row diet-feature-section">
    <div class="col-sm-5">
        <img src="<?= Url::to('/img/layout/diet/diet-3.jpg') ?>" alt="Habits" class="img-responsive">
    </div>
    <div class="col-sm-5 col-sm-offset-1">
        <p class="diet-feature-subtitle">HABIT TRACKERS</p>
        <h2 class="diet-feature-title">Track your habits</h2>
        <p class="diet-feature-text">
            Log your meals and workouts to track your progress. We've made things fast and easy with shortcuts to your
            favorite meals and a huge library of foods. Hey, we even have 3D Touch, if your phone can handle it.
        </p>
    </div>
</div>

<div class="row diet-feature-section">
    <div class="col-sm-5 col-sm-offset-1">
        <p class="diet-feature-subtitle">LIFE SCORE</p>
        <h2 class="diet-feature-title">Get the feedback and support you need</h2>
        <p class="diet-feature-text">
            We'll keep you on track and in the right mindset with daily feedback, suggestions and the occasional
            motivational cheer.
        </p>
    </div>
    <div class="col-sm-5">
        <img src="<?= Url::to('/img/layout/diet/diet-4.jpg') ?>" alt="Feedback" class="img-responsive">
    </div>
</div>

<div class="row diet-feature-section">
    <div class="col-sm-5">
        <img src="<?= Url::to('/img/layout/diet/diet-5.jpg') ?>" alt="Unite" class="img-responsive">
    </div>
    <div class="col-sm-5 col-sm-offset-1">
        <p class="diet-feature-subtitle">FRIENDS</p>
        <h2 class="diet-feature-title">Health-freaks of the world unite!</h2>
        <p class="diet-feature-text">
            Everything is more fun when you're part of a gang. Find your Yummy Diet friends to share tips and stay inspired
            on your health journey!
        </p>
    </div>
</div>

<hr>

<div class="diet-feature-section premium">
    <h4 class="premium-text">YUMMY DIET PREMIUM</h4>
    <h2 class="diet-feature-title">Boost your chances of success by 241%</h2>
    <p class="diet-feature-text">Better features, more control, and even more personal.</p>
    <button class="btn btn-success btn-round btn-lg">FIND OUT MORE</button>
</div>