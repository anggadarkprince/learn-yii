<?php

namespace app\models;

use yii\base\Object;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

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
     * Check synchronize recipe tags.
     * @param $tags
     * @param bool $autoSave
     * @param bool $autoMerge
     * @return array
     */
    public function checkSyncTags($tags, $autoSave = true, $autoMerge = true)
    {
        $tagsData = null;
        if (is_array($tags)) {
            $tagsData = $tags;
        } else {
            $tagsData = explode(',', $tags);
        }
        $existTags = [];
        $newTags = [];
        foreach ($tagsData as $tagName) {
            $tagSlug = Inflector::slug($tagName);
            $tagModel = static::find()->where(['slug' => $tagSlug])->one();
            if (is_null($tagModel)) {
                $newTag = new Tag();
                $newTag->slug = $tagSlug;
                $newTag->tag = $tagName;
                if ($autoSave) {
                    $newTag->save();
                }
                $newTags[] = $newTag;
            } else {
                $existTags[] = $tagModel;
            }
        }

        if ($autoMerge) {
            return array_merge($existTags, $newTags);
        }

        $tagsWrapper = new Object();
        $tagsWrapper->new = $newTags;
        $tagsWrapper->exist = $existTags;
        return $tagsWrapper;
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
