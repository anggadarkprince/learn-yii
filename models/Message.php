<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

/**
 * This is the model class for table "messages".
 *
 * @property integer $id
 * @property integer $sender_id
 * @property integer $receiver_id
 * @property string $message
 * @property integer $is_available_sender
 * @property integer $is_available_receiver
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $receiver
 * @property User $sender
 */
class Message extends ActiveRecord
{
    /**
     * Default table name.
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * Field form rules.
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender_id', 'receiver_id', 'is_available_sender', 'is_available_receiver'], 'integer'],
            [['message'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['receiver_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['receiver_id' => 'id']],
            [['sender_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['sender_id' => 'id']],
        ];
    }

    /**
     * Alias attributes of message data.
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender_id' => 'Sender',
            'receiver_id' => 'Receiver',
            'message' => 'Message',
            'is_available_sender' => 'Is Available Sender',
            'is_available_receiver' => 'Is Available Receiver',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Get receiver of this message.
     * @return \yii\db\ActiveQuery
     */
    public function getReceiver()
    {
        return $this->hasOne(User::className(), ['id' => 'receiver_id']);
    }

    /**
     * Get sender of this message.
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'sender_id']);
    }

    /**
     * @param $userId
     * @return Query
     */
    public function getMessages($userId)
    {
        $messagesQuery = (new Query())->select([
            'id',
            'IF(sender_id = 1, receiver_id, sender_id) AS user_id',
            'message',
            'is_available_sender',
            'is_available_receiver',
            'created_at'
        ])
            ->from('messages')
            ->where(['sender_id' => $userId])
            ->orWhere(['receiver_id' => $userId]);

        $sendersQuery = (new Query())->select(['senders.user_id', 'sender_id'])
            ->from('messages')
            ->innerJoin(['senders' => "
                (SELECT 
                  MIN(id) AS id, 
                  IF(sender_id = :user_id, receiver_id, sender_id) AS user_id
                FROM messages
                WHERE sender_id = :user_id 
                  OR receiver_id = :user_id
                GROUP BY user_id)
            "], 'senders.id = messages.id', [':user_id' => $userId]);

        $messageList = (new Query())
            ->select(['messages.*', 'senders.sender_id', 'users.name', 'users.username', 'users.avatar'])
            ->from(['messages' => $messagesQuery])
            ->leftJoin(['last_messages' => $messagesQuery], 'messages.user_id = last_messages.user_id AND messages.id < last_messages.id')
            ->innerJoin(['senders' => $sendersQuery], 'senders.user_id = messages.user_id')
            ->innerJoin('users', 'users.id = messages.user_id')
            ->where('last_messages.id IS NULL')
            ->andWhere('IF(sender_id = 1, messages.is_available_sender, messages.is_available_receiver) = 1')
            ->orderBy(['messages.created_at' => SORT_DESC]);

        return $messageList;
    }

    /**
     * Get conversation between 2 person.
     * @param $userId
     * @param $withUserId
     * @return ActiveQuery
     */
    public function getConversations($userId, $withUserId)
    {
        $sendersQuery = (new Query())->select(['senders.user_id', 'sender_id'])
            ->from('messages')
            ->innerJoin(['senders' => "
                (SELECT 
                  MIN(id) AS id, 
                  IF(sender_id = :user_id, receiver_id, sender_id) AS user_id
                FROM messages
                WHERE sender_id = :user_id 
                  OR receiver_id = :user_id
                GROUP BY user_id)
            "], 'senders.id = messages.id', [':user_id' => $userId])
        ->where(['user_id' => $withUserId])->one();

        return self::find()
            ->where(['sender_id' => $userId, 'receiver_id' => $withUserId])
            ->orWhere(['sender_id' => $withUserId, 'receiver_id' => $userId])
            ->andWhere('IF(:senderId = :userId, is_available_sender, is_available_receiver) = 1', [
                ':senderId' => $sendersQuery['sender_id'],
                ':userId' => $userId
            ]);
    }
}
