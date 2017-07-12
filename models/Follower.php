<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "followers".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $following_id
 * @property string $created_at
 *
 * @property Users $following
 * @property Users $user
 */
class Follower extends ActiveRecord
{
    /**
     * Set default followers table name.
     */
    public static function tableName()
    {
        return 'followers';
    }

    /**
     * Get validation rules.
     */
    public function rules()
    {
        return [
            [['user_id', 'following_id'], 'required'],
            [['user_id', 'following_id'], 'integer'],
            [['created_at'], 'safe'],
            [['following_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['following_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * Get attribute label for validation or title.
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'following_id' => 'Following',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Get user list that followed by current user.
     * @return \yii\db\ActiveQuery
     */
    public function getFollowing()
    {
        return $this->hasOne(User::className(), ['id' => 'following_id']);
    }

    /**
     * Get user list that following by current user.
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function unfollow()
    {
        return static::find()
            ->where([
                'user_id' => $this->user_id,
                'following_id' => $this->following_id
            ])
            ->one()
            ->delete();
    }
}
