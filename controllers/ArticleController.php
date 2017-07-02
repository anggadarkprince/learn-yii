<?php

namespace app\controllers;

use app\models\Article;
use yii\data\Pagination;
use yii\web\Controller;

class ArticleController extends Controller
{
    /**
     * Show index blog articles.
     * @return string
     */
    public function actionIndex()
    {
        $articleQuery = Article::find();

        $pagination = new Pagination([
            'defaultPageSize' => 8,
            'totalCount' => $articleQuery->count(),
        ]);

        $articles = $articleQuery->latest()->published()
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'articles' => $articles,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Show articles by year and month.
     * @param $year
     * @param $month
     * @return string
     */
    public function actionArchive($year, $month)
    {
        $article = new Article();
        $archive = $article->getArchiveLabels($year, $month);
        $articleQuery = $article->getArchives($year, $month);

        $pagination = new Pagination([
            'defaultPageSize' => 8,
            'totalCount' => $articleQuery->count(),
        ]);

        $articles = $articleQuery->latest()->published()
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('archive', [
            'archive' => $archive,
            'articles' => $articles,
            'pagination' => $pagination,
        ]);
    }

    /**
     * View article post content.
     * @param $slug
     * @return string
     */
    public function actionView($slug)
    {
        $article = Article::find()->slug($slug)->one();
        return $this->render('view', ['article' => $article]);
    }

}
