<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "directions".
 *
 * @property integer $id
 * @property integer $recipe_id
 * @property string $direction
 * @property string $created_at
 *
 * @property Recipe $recipe
 */
class Direction extends ActiveRecord
{
    /**
     * Set default table name.
     */
    public static function tableName()
    {
        return 'directions';
    }

    /**
     * Get validation rules according to table field.
     */
    public function rules()
    {
        return [
            [['recipe_id', 'direction'], 'required'],
            [['recipe_id'], 'integer'],
            [['created_at'], 'safe'],
            [['direction'], 'string', 'max' => 700],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::className(), 'targetAttribute' => ['recipe_id' => 'id']],
        ];
    }

    /**
     * Get attribute label for validation or title.
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recipe_id' => 'Recipe ID',
            'direction' => 'Direction',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Get receipt belong to direction.
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }
}
