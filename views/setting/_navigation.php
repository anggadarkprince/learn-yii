<?php
/* @var $user app\models\User */
use yii\helpers\Url;

?>
<small class="setting-navigation-title">SETTINGS</small>
<ul class="list-unstyled setting-navigation">
    <li<?= Yii::$app->controller->action->id == 'application' ? ' class="active"' : '' ?>>
        <a href="<?= Url::toRoute('/settings') ?>">
            <i class="icon-layers"></i>Application
        </a>
    </li>
    <li<?= Yii::$app->controller->action->id == 'profile' ? ' class="active"' : '' ?>>
        <a href="<?= Url::toRoute('settings/profile') ?>">
            <i class="icon-user"></i>Profile
        </a>
    </li>
    <li<?= Yii::$app->controller->action->id == 'password' ? ' class="active"' : '' ?>>
        <a href="<?= Url::toRoute('settings/password') ?>">
            <i class="icon-lock"></i>Password
        </a>
    </li>
    <li<?= Yii::$app->controller->action->id == 'security' ? ' class="active"' : '' ?>>
        <a href="<?= Url::toRoute('settings/security') ?>">
            <i class="icon-key"></i>Security
        </a>
    </li>
    <li<?= Yii::$app->controller->action->id == 'notification' ? ' class="active"' : '' ?>>
        <a href="<?= Url::toRoute('settings/notification') ?>">
            <i class="icon-bell"></i>Notification
        </a>
    </li>
    <li<?= Yii::$app->controller->action->id == 'social' ? ' class="active"' : '' ?>>
        <a href="<?= Url::toRoute('settings/social') ?>">
            <i class="icon-social-twitter"></i>Social
        </a>
    </li>
    <li<?= Yii::$app->controller->action->id == 'privacy' ? ' class="active"' : '' ?>>
        <a href="<?= Url::toRoute('settings/privacy') ?>">
            <i class="icon-flag"></i>Privacy
        </a>
    </li>
    <li<?= Yii::$app->controller->action->id == 'accessibility' ? ' class="active"' : '' ?>>
        <a href="<?= Url::toRoute('settings/accessibility') ?>">
            <i class="icon-support"></i>Accessibility
        </a>
    </li>
</ul>
<hr>
<small class="setting-navigation-title">OTHERS</small>
<ul class="list-unstyled setting-navigation">
    <li><a href="<?= Url::toRoute('/help') ?>">Help Center</a></li>
    <li><a href="<?= Url::toRoute('/keyboard') ?>">Keyboard Shortcut</a></li>
    <li><a href="<?= Url::toRoute('/ads') ?>">Advertisement</a></li>
</ul>
