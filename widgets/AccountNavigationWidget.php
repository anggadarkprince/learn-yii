<?php

namespace app\widgets;

use app\models\User;
use yii\base\Widget;

/**
 * Class AccountSidebarWidget
 * @package app\widgets
 * @property User $user
 */

class AccountNavigationWidget extends Widget
{
    public $active;
    public $user;

    public function init()
    {
        parent::init();
        if ($this->active === null) {
            $this->active = 'recipe';
        }
    }

    public function run()
    {
        return $this->render('navigation', [
            'user' => $this->user,
            'active' => $this->active,
        ]);
    }
}