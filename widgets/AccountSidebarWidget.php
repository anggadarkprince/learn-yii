<?php

namespace app\widgets;

use app\models\User;
use yii\base\Widget;

/**
 * Class AccountSidebarWidget
 * @package app\widgets
 * @property User $user
 */

class AccountSidebarWidget extends Widget
{
    public $user;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('sidebar', [
            'user' => $this->user,
            'followers' => $this->user->getFollowers(10),
            'followings' => $this->user->getFollowings(10),
        ]);
    }
}