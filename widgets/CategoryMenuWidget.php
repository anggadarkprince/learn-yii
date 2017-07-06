<?php

namespace app\widgets;

use app\models\Category;
use yii\base\Widget;

class CategoryMenuWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $categories = Category::find()
            ->select(['category'])
            ->indexBy('slug')
            ->column();
        return $this->render('menu', ['categories' => $categories]);
    }
}