<?php

namespace app\widgets;

use app\models\Article;
use app\models\Category;
use app\models\User;
use yii\base\Widget;

/**
 * Class BlogSidebarWidget
 * @package app\widgets
 * @property User $user
 */

class BlogSidebarWidget extends Widget
{
    public function run()
    {
        $article = new Article();
        return $this->render('blog_sidebar', [
            'articles' => $article->getRecentPost(),
            'archives' => $article->getArchiveGroups(),
            'categories' => Category::find()->all(),
        ]);
    }
}