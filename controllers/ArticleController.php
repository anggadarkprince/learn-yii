<?php

namespace app\controllers;

use app\models\Article;
use yii\data\Pagination;
use yii\web\Controller;

class ArticleController extends Controller
{
    public function actionIndex()
    {
        $articleQuery = Article::find();

        $pagination = new Pagination([
            'defaultPageSize' => 8,
            'totalCount' => $articleQuery->count(),
        ]);

        $articles = $articleQuery->orderBy(['created_at' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'articles' => $articles,
            'pagination' => $pagination,
        ]);
    }

    public function actionArchive($year, $month)
    {
        return $this->renderContent('Show archive ' . $year.'/'.$month);
    }

    public function actionView($slug)
    {
        return $this->renderContent('Show article ' . $slug);
    }

}
