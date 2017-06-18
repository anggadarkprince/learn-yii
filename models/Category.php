<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $category
 * @property string $slug
 * @property string $description
 * @property string $feature
 * @property integer $parent
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Recipes[] $recipes
 */
class Category extends ActiveRecord
{
    /**
     * Get default table name.
     * @return string
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * Validation rules according to table columns.
     * @return array
     */
    public function rules()
    {
        return [
            [['category', 'slug', 'description'], 'required'],
            [['parent'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['category'], 'string', 'max' => 50],
            [['slug'], 'string', 'max' => 100],
            [['description', 'feature'], 'string', 'max' => 300],
        ];
    }

    /**
     * Attributes label for validation or title.
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'slug' => 'Slug',
            'description' => 'Description',
            'feature' => 'Feature',
            'parent' => 'Parent',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Get all related receipts of current category data.
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipes::className(), ['category_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    /**
     * Get category list.
     * @return Category[]|array
     */
    public static function findsCategor()
    {
        return Category::find()->select(['id', 'category', 'description', 'featured'])->all();
    }
}
