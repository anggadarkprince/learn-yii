<?php

namespace app\widgets;

use app\models\Category;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

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
        $menu .= '<li><a href="' . Url::to('/recipe') . '">All Recipes</a></li>';
        foreach ($categories as $data) {
            $menu .= '<li>';
            $menu .= '<a href="' . Url::to(['category/' . $data->slug]) . '">';
            $menu .= $data->category;
            $menu .= '</a>';
            $menu .= '</li>';
        }
        $menu .= '</ul>';
        return $menu;
    }
}