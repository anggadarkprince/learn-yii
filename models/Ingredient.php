<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ingredients".
 *
 * @property integer $id
 * @property integer $recipe_id
 * @property string $ingredient
 * @property string $created_at
 *
 * @property Recipe $recipe
 */
class Ingredient extends ActiveRecord
{
    /**
     * Set default table name.
     */
    public static function tableName()
    {
        return 'ingredients';
    }

    /**
     * Get validation rule.
     */
    public function rules()
    {
        return [
            [['recipe_id', 'ingredient'], 'required'],
            [['recipe_id'], 'integer'],
            [['created_at'], 'safe'],
            [['ingredient'], 'string', 'max' => 500],
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
            'ingredient' => 'Ingredient',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Get recipe belong to current ingredient.
     * @return \yii\db\ActiveQuery
     */
    public function getRecipe()
    {
        return $this->hasOne(Recipe::className(), ['id' => 'recipe_id']);
    }
}
