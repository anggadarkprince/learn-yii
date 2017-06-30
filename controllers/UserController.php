<?php

namespace app\controllers;

use app\models\User;
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
        return $this->render('view', [
            'user' => $user,
            'recipes' => $user->recipes,
            'followers' => $user->getFollowers(10),
            'followings' => $user->getFollowings(10),
        ]);
    }

}
