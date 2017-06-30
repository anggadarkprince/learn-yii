<?php

namespace app\widgets;

use yii\base\Widget;

class RatingWidget extends Widget
{
    public $ratings;
    public $isStarOnly;

    public function init()
    {
        parent::init();
        if ($this->ratings === null) {
            $this->ratings = 0;
        }
        if ($this->ratings === null) {
            $this->isStarOnly = false;
        }
    }

    public function run()
    {
        return $this->render('rating', [
            'ratings' => $this->ratings,
            'isStarOnly' => $this->isStarOnly,
        ]);
    }
}