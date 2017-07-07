<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\User;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\HttpException;

class UserController extends Controller
{
    /**
     * Show user profile.
     * @param $username
     * @return string
     * @throws HttpException
     */
    public function actionView($username)
    {
        $user = User::findByUsername($username);
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
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
     * @throws HttpException
     */
    public function actionFavorites($username)
    {
        $user = User::findByUsername($username);
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
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
     * @throws HttpException
     */
    public function actionMade($username)
    {
        $user = User::findByUsername($username);
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
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
     * @throws HttpException
     */
    public function actionFollowing($username)
    {
        $user = User::findByUsername($username);
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
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
     * @throws HttpException
     */
    public function actionFollowers($username)
    {
        $user = User::findByUsername($username);
        if (is_null($user)) {
            throw new HttpException(404, 'Cooker not found');
        }
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

    /**
     * Login action.
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/' . Yii::$app->user->identity->username);
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Show register form.
     * @return string|\yii\web\Response
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
