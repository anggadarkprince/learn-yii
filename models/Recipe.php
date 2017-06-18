<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "recipes".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $preparation_time
 * @property string $cook_time
 * @property string $tips
 * @property integer $servings
 * @property integer $calories
 * @property string $privacy
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Directions[] $directions
 * @property Ingredients[] $ingredients
 * @property Ratings[] $ratings
 * @property RecipeTags[] $recipeTags
 * @property Tags[] $tags
 * @property Categories $category
 * @property Users $user
 */
class Recipe extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recipes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'title', 'slug', 'description'], 'required'],
            [['user_id', 'category_id', 'servings', 'calories'], 'integer'],
            [['preparation_time', 'cook_time', 'created_at', 'updated_at'], 'safe'],
            [['privacy'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 500],
            [['tips'], 'string', 'max' => 300],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => 'Category ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
            'preparation_time' => 'Preparation Time',
            'cook_time' => 'Cook Time',
            'tips' => 'Tips',
            'servings' => 'Servings',
            'calories' => 'Calories',
            'privacy' => 'Privacy',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirections()
    {
        return $this->hasMany(Direction::className(), ['recipe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['recipe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::className(), ['recipe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('recipe_tags', ['recipe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return RecipesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RecipesQuery(get_called_class());
    }
}
