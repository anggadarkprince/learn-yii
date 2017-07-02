<?php

namespace app\controllers;

use app\models\Tag;
use yii\data\Pagination;
use yii\web\Controller;

class TagController extends Controller
{
    /**
     * Get recipes from tag slug.
     * @param $slug
     * @return string
     */
    public function actionRecipe($slug)
    {
        /* @var $tag Tag */
        $tag = Tag::find()->where(['slug' => $slug])->one();
        $recipeQuery = $tag->getRecipes();

        $pagination = new Pagination([
            'defaultPageSize' => 12,
            'totalCount' => $recipeQuery->count(),
        ]);

        $recipes = $recipeQuery->orderBy(['created_at' => SORT_DESC])
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        return $this->render('recipe', [
            'tag' => $tag,
            'recipes' => $recipes,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Get articles from tag slug.
     * @param $slug
     * @return string
     */
    public function actionArticle($slug)
    {
        /* @var $tag Tag */
        $tag = Tag::find()->where(['slug' => $slug])->one();
        $articleQuery = $tag->getArticles();

        $pagination = new Pagination([
            'defaultPageSize' => 8,
            'totalCount' => $articleQuery->count(),
        ]);

        $articles = $articleQuery->latest()->published()
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        return $this->render('article', [
            'tag' => $tag,
            'articles' => $articles,
            'pagination' => $pagination,
        ]);
    }

}
