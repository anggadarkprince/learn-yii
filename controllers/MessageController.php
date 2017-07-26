<?php

namespace app\controllers;

use app\models\Message;
use app\models\User;
use Yii;
use yii\web\Controller;

class MessageController extends Controller
{
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        $message = new Message();
        $messages = $message->getMessages($user->getId())->all();

        return $this->render('index', [
            'messages' => $messages,
            'user' => $user
        ]);
    }

    public function actionConversation($interactWithUser)
    {
        $user = Yii::$app->user->identity;
        $interactWith = User::findByUsername($interactWithUser);
        $message = new Message();
        $conversations = $message->getConversations($user->getId(), $interactWith->getId())->all();
        return $this->render('conversation', [
            'conversations' => $conversations,
            'partner' => $interactWith,
            'user' => $user
        ]);
    }

}
