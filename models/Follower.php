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
            [['following_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['following_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * Get attribute label for validation or title.
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'following_id' => 'Following ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Get user list that followed by current user.
     * @return \yii\db\ActiveQuery
     */
    public function getFollowing()
    {
        return $this->hasOne(Users::className(), ['id' => 'following_id']);
    }

    /**
     * Get user list that following by current user.
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
