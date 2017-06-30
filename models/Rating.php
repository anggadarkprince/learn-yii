<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ratings".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $recipe_id
 * @property integer $rate
 * @property string $review
 * @property integer $vote
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Recipe $recipe
 * @property User $user
 */
class Rating extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ratings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'recipe_id', 'review'], 'required'],
            [['user_id', 'recipe_id', 'rate', 'vote'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['review'], 'string', 'max' => 500],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipes::className(), 'targetAttribute' => ['recipe_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'recipe_id' => 'Recipe ID',
            'rate' => 'Rate',
            'review' => 'Review',
            'vote' => 'Vote',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
