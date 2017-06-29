<?php

namespace app\modules\admin;

use yii\base\Module;

/**
 * admin module definition class
 */
class Recipe extends Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
