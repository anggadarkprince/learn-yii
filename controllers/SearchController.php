<?php

namespace app\controllers;

use app\models\Article;
use app\models\Recipe;
use app\models\User;
use yii\data\Pagination;
use yii\web\Controller;

class SearchController extends Controller
{
    /**
     * Search recipes, people or articles.
     * @param $q
     * @param string $f
     * @return string
     */
    public function actionIndex($q, $f = 'recipes')
    {
        $resultQuery = null;
        switch ($f) {
            case 'recipes':
                $recipe = new Recipe();
                $resultQuery = $recipe->search($q);
                break;
            case 'people':
                $user = new User();
                $resultQuery = $user->search($q);
                break;
            case 'articles':
                $article = new Article();
                $resultQuery = $article->search($q);
                break;
        }

        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $resultQuery->count(),
        ]);

        $result = $resultQuery->orderBy(['created_at' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'query' => $q,
            'filter' => $f,
            'result' => $result,
            'pagination' => $pagination,
        ]);
    }

}
