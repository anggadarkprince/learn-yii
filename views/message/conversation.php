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
                <div class="col-md-10 col-lg-8 col-lg-offset-2 col-md-offset-1">
                    <h3 class="lead">Conversation with @<?= $partner->username ?></h3>
                    <div class="conversation-list">
                        <?php foreach ($conversations as $conversation): ?>
                            <div class="conversation-wrapper">
                                <div class="conversation-item<?= $conversation->sender_id == $partner->id ? '' : ' conversation-me pull-right text-right' ?>">
                                    <div style="background: url('<?= Url::to('/img/avatars/'.$conversation->sender->avatar) ?>') center center / cover"
                                         class="conversation-avatar"></div>
                                    <div class="conversation-content">
                                        <p><?= $conversation->message ?></p>
                                        <time><?= (new DateTime($conversation->created_at))->format('d F Y H:i') ?></time>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="message-box">
                        <div class="form-group">
                            <textarea class="form-control" name="message" id="message" cols="30" placeholder="Type a message"></textarea>
                        </div>
                        <button class="btn btn-primary pull-right">Send Message</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>