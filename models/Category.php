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
 * @property Article[] $articles
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
     * Get all related recipes of current category data.
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['category_id' => 'id']);
    }

    /**
     * Get all related articles of current category data.
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
    }

    /**
     * Get total recipe by specific or all categories.
     * @param null $categoryId
     * @return int|string
     */
    public function getTotalRecipe($categoryId = null)
    {
        $totalReview = Category::find()
            ->innerJoin('recipes', 'categories.id = recipes.category_id');

        if(is_null($categoryId)){
            $totalReview->where(['categories.id' => $this->id]);
        }
        return $totalReview->count();
    }

    /**
     * Get total cooker by specific or all categories.
     * @param null $categoryId
     * @return int|string
     */
    public function getTotalCooked($categoryId = null)
    {
        $totalReview = Category::find()
            ->innerJoin('recipes', 'categories.id = recipes.category_id')
            ->innerJoin('cookers', 'recipes.id = cookers.recipe_id');

        if(is_null($categoryId)){
            $totalReview->where(['categories.id' => $this->id]);
        }
        return $totalReview->count();
    }

    /**
     * Get total like by specific or all categories.
     * @param null $categoryId
     * @return int|string
     */
    public function getTotalLike($categoryId = null)
    {
        $totalReview = Category::find()
            ->innerJoin('recipes', 'categories.id = recipes.category_id')
            ->innerJoin('favorites', 'recipes.id = favorites.recipe_id');

        if(is_null($categoryId)){
            $totalReview->where(['categories.id' => $this->id]);
        }
        return $totalReview->count();
    }

    /**
     * Get total recipe review by specific or all category.
     * @param $categoryId
     * @return int|string
     */
    public function getTotalReview($categoryId = null)
    {
        $totalReview = Category::find()
            ->innerJoin('recipes', 'categories.id = recipes.category_id')
            ->innerJoin('ratings', 'recipes.id = ratings.recipe_id');

        if(is_null($categoryId)){
            $totalReview->where(['categories.id' => $this->id]);
        }
        return $totalReview->count();
    }

    /**
     * Get category list.
     * @return Category[]|array
     */
    public static function findsCategory()
    {
        return Category::find()->select(['id', 'category', 'description', 'feature'])->all();
    }

    /**
     * Get category list key-value.
     * @return array
     */
    public function findCategoryList()
    {
        $categories = self::findsCategory();
        $categoryList = [];
        foreach ($categories as $category) {
            $categoryList[$category->id] = $category->category;
        }
        return $categoryList;
    }
}
