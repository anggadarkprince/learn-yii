<?php

namespace app\controllers;

use app\models\User;
use yii\data\Pagination;
use yii\web\Controller;

class UserController extends Controller
{
    /**
     * Show user profile.
     * @param $username
     * @return string
     */
    public function actionView($username)
    {
        $user = User::findByUsername($username);
        $recipeQuery = $user->getRecipes();

        $pagination = new Pagination([
            'defaultPageSize' => 9,
            'totalCount' => $recipeQuery->count(),
        ]);

        $recipes = $recipeQuery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('recipe', [
            'user' => $user,
            'recipes' => $recipes,
            'pagination' => $pagination,
            'active' => 'recipes',
        ]);
    }

    /**
     * Get favorite recipes of user.
     * @param $username
     * @return string
     */
    public function actionFavorites($username)
    {
        $user = User::findByUsername($username);
        $recipeQuery = $user->getFavorites();

        $pagination = new Pagination([
            'defaultPageSize' => 9,
            'totalCount' => $recipeQuery->count(),
        ]);

        $recipes = $recipeQuery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('recipe', [
            'user' => $user,
            'recipes' => $recipes,
            'pagination' => $pagination,
            'active' => 'favorites',
        ]);
    }

    /**
     * Get made recipes of user.
     * @param $username
     * @return string
     */
    public function actionMade($username)
    {
        $user = User::findByUsername($username);
        $recipeQuery = $user->getCooks();

        $pagination = new Pagination([
            'defaultPageSize' => 9,
            'totalCount' => $recipeQuery->count(),
        ]);

        $recipes = $recipeQuery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('recipe', [
            'user' => $user,
            'recipes' => $recipes,
            'pagination' => $pagination,
            'active' => 'made',
        ]);
    }

    /**
     * Get following user.
     * @param $username
     * @return string
     */
    public function actionFollowing($username)
    {
        $user = User::findByUsername($username);
        $followingQuery = $user->getFollowings();

        $pagination = new Pagination([
            'defaultPageSize' => 9,
            'totalCount' => $followingQuery->count(),
        ]);

        $followings = $followingQuery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('follower', [
            'user' => $user,
            'users' => $followings,
            'pagination' => $pagination,
            'active' => 'following',
        ]);
    }

    /**
     * Get following user.
     * @param $username
     * @return string
     */
    public function actionFollowers($username)
    {
        $user = User::findByUsername($username);
        $followingQuery = $user->getFollowers();

        $pagination = new Pagination([
            'defaultPageSize' => 9,
            'totalCount' => $followingQuery->count(),
        ]);

        $followings = $followingQuery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('follower', [
            'user' => $user,
            'users' => $followings,
            'pagination' => $pagination,
            'active' => 'followers',
        ]);
    }
}
