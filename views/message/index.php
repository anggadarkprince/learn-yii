<?php
/* @var $this yii\web\View */
/* @var $pagination \yii\data\Pagination */
/* @var $user app\models\User */
/* @var $stream [] app\models\Recipe */

/* @var $active string */

use app\widgets\AccountSidebarWidget;
use yii\helpers\Url;

$this->title = $user->name . ' (' . $user->username . ') - Yummy';

?>

<div class="row account-wrapper home-stream">
    <div class="col-md-3">
        <?= AccountSidebarWidget::widget(['user' => $user]) ?>
    </div>
    <div class="col-md-9">
        <div class="account-content">
            <div class="row">
                <div class="col-md-10 col-lg-offset-1">
                    <h3 class="lead">Messages</h3>
                    <div class="message-list">
                        <?php foreach ($messages as $message): ?>
                            <div class="message-item">
                                <div class="dropdown pull-right">
                                    <i class="icon-options-vertical" data-toggle="dropdown"></i>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-header">Action</li>
                                        <li><a href="javascript:void(0)">Report @<?= $message['username'] ?></a></li>
                                        <li><a href="<?= Url::toRoute('message/archive/'. $message['username']) ?>">Archive Message</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="<?= Url::toRoute('message/delete/' . $message['username']) ?>">Delete Conversation</a></li>
                                    </ul>
                                </div>
                                <a href="<?= Url::toRoute(['message/conversation/' . $message['username']]) ?>" class="message-wrapper">
                                    <div style="background: url('<?= Url::to('/img/avatars/'.$message['avatar']) ?>') center center / cover"
                                         class="message-avatar"></div>
                                    <div class="message-content">
                                        <p><?= $message['message'] ?></p>
                                        <time>23 minutes ago</time>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>