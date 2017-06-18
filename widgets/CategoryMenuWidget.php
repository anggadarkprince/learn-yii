<?php

namespace app\widgets;

use app\models\Category;
use yii\base\Widget;
use yii\helpers\Html;

class CategoryMenuWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $categories = Category::find()->all();
        $menu = '<ul class="dropdown-menu">';
        foreach ($categories as $data) {
            $menu .= '<li>';
            $menu .= '<a href="/basic/web/index.php?r=category/' . $data->slug . '">';
            $menu .= $data->category;
            $menu .= '</a>';
            $menu .= '</li>';
        }
        $menu .= '</ul>';
        return $menu;
    }
}