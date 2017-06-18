<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $tag
 * @property string $slug
 * @property string $created_at
 * @property string $updated_at
 *
 * @property RecipeTags[] $recipeTags
 * @property Recipes[] $recipes
 */
class Tag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag', 'slug'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['tag'], 'string', 'max' => 50],
            [['slug'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag' => 'Tag',
            'slug' => 'Slug',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])->viaTable('recipe_tags', ['tag_id' => 'id']);
    }
}
