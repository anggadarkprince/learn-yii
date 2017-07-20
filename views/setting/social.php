<?php
/* @var $this yii\web\View */
/* @var $pagination \yii\data\Pagination */
/* @var $user app\models\User */
/* @var $recipes [] app\models\Recipe */
/* @var $active string */

use app\widgets\AccountNavigationWidget;
use app\widgets\AccountSidebarWidget;

$this->title = 'Setting Social - Yummy';

?>

<?php $this->beginBlock('account-banner'); ?>
<?= AccountNavigationWidget::widget(['user' => $user]) ?>
<?php $this->endBlock(); ?>

<div class="row account-wrapper">
    <div class="col-md-3">
        <?= AccountSidebarWidget::widget(['user' => $user]) ?>
    </div>
    <div class="col-md-9">
        <div class="account-content">

            <div class="row setting-content">
                <div class="col-md-10 col-lg-offset-1">
                    <div class="row">
                        <div class="col-md-4">
                            <?= $this->render('_navigation', ['user' => $user]) ?>
                        </div>
                        <div class="col-md-8">

                            <?= $this->render('../errors/_general_alert') ?>

                            <div class="form-title">
                                <h3 class="lead">Social</h3>
                                <p>Integrate your social network with yummy to auto login and post</p>
                            </div>

                            <ul class="list-unstyled setting-social">
                                <li>
                                    <button class="btn btn-primary pull-right">
                                        <i class="fa fa-facebook"></i> Facebook
                                    </button>
                                    <h4>Facebook</h4>
                                    <p>Login and post recipe to your feed</p>
                                    <div class="text-primary">
                                        Connected as <strong>Angga Ari Wijaya</strong>
                                    </div>
                                </li>
                                <li>
                                    <button class="btn btn-info pull-right">
                                        <i class="fa fa-twitter"></i> Twitter
                                    </button>
                                    <h4>Twitter</h4>
                                    <p>Login and tweet recipe to your feed</p>
                                </li>
                                <li>
                                    <button class="btn btn-danger pull-right">
                                        <i class="fa fa-google"></i> Google
                                    </button>
                                    <h4>Google</h4>
                                    <p>Login and post recipe to your feed</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>