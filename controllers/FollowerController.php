<?php

namespace app\controllers;

use app\models\Follower;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

class FollowerController extends Controller
{

    /**
     * Set respond as JSON
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * Following a user.
     * @return array
     * @throws HttpException
     */
    public function actionFollow()
    {
        if (Yii::$app->user->isGuest) {
            throw new HttpException(201, 'Unauthorized');
        } else {
            $followingId = Yii::$app->request->post('following_id');
            if (Yii::$app->user->identity->isFollow($followingId)) {
                $success = false;
                $name = 'Bad Request';
                $message = 'User is already followed';
                $code = 1001;
                $status = 400;
            } else {
                $model = new Follower();
                $model->user_id = Yii::$app->user->id;
                $model->following_id = $followingId;
                if ($model->validate() && Yii::$app->request->isAjax) {
                    if ($model->save()) {
                        $success = true;
                        $name = 'OK';
                        $message = 'Following user success';
                        $code = 1000;
                        $status = 200;
                    } else {
                        $success = false;
                        $name = 'Internal Server Error';
                        $message = 'Following user failed';
                        $code = 1002;
                        $status = 500;
                    }
                } else {
                    $success = false;
                    $name = 'Bad Request';
                    $message = 'Invalid data parameter';
                    $code = 1003;
                    $status = 400;
                }
            }
        }

        Yii::$app->response->statusCode = $status;
        return [
            'success' => $success,
            'data' => [
                "name" => $name,
                "message" => $message,
                "code" => $code,
                "status" => $status
            ]
        ];
    }

    /**
     * Unfollow a user.
     * @return array
     * @throws HttpException
     */
    public function actionUnfollow()
    {
        if (Yii::$app->user->isGuest) {
            throw new HttpException(201, 'Unauthorized');
        } else {
            $followingId = Yii::$app->request->post('following_id', 6);
            if (Yii::$app->user->identity->isFollow($followingId)) {
                $model = new Follower();
                $model->user_id = Yii::$app->user->id;
                $model->following_id = $followingId;
                if ($model->validate() && Yii::$app->request->isAjax) {
                    if ($model->unfollow()) {
                        $success = true;
                        $name = 'OK';
                        $message = 'Unfollowing user success';
                        $code = 2000;
                        $status = 200;
                    } else {
                        $success = false;
                        $name = 'Internal Server Error';
                        $message = 'Unfollowing user failed';
                        $code = 2002;
                        $status = 500;
                    }
                } else {
                    $success = false;
                    $name = 'Bad Request';
                    $message = 'Invalid data parameter';
                    $code = 2003;
                    $status = 400;
                }
            } else {
                $success = false;
                $name = 'Bad Request';
                $message = 'User is already unfollowed';
                $code = 2001;
                $status = 400;
            }
        }

        Yii::$app->response->statusCode = 200;
        return [
            'success' => $success,
            'data' => [
                "name" => $name,
                "message" => $message,
                "code" => $code,
                "status" => $status
            ]
        ];
    }
}
