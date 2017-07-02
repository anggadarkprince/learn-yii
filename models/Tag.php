<?php

namespace app\models;

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
 * @property Recipe[] $recipes
 * @property Article[] $articles
 */
class Tag extends ActiveRecord
{
    /**
     * Set default table name.
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * Set input field rules.
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
     * Set attribute labels of tag.
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
     * Get related recipes by current tag model.
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])
            ->viaTable('recipe_tags', ['tag_id' => 'id']);
    }

    /**
     * Get related article by current tag model.
     * @return ArticleQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])
            ->viaTable('article_tags', ['tag_id' => 'id']);
    }
}
