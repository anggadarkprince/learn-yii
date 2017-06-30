<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;

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
 * @property string $feature
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Direction[] $directions
 * @property Ingredient[] $ingredients
 * @property Rating[] $ratings
 * @property RecipeTags[] $recipeTags
 * @property Tag[] $tags
 * @property Recipe[] $relatedRecipes
 * @property Category $category
 * @property User $user
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
            [['user_id', 'category_id', 'title', 'slug', 'description', 'feature'], 'required'],
            [['user_id', 'category_id', 'servings', 'calories'], 'integer'],
            [['preparation_time', 'cook_time', 'created_at', 'updated_at'], 'safe'],
            [['privacy'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 500],
            [['tips'], 'string', 'max' => 300],
            [['feature'], 'string', 'max' => 300],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'category_id' => 'Category',
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
     * Get related recipe by similar tags.
     * @param int $totalMax
     * @param null $recipeId
     * @return array|ActiveRecord[]
     */
    public function getRelatedRecipes($totalMax = 6, $recipeId = null)
    {
        $recipeId = is_null($recipeId) ? $this->id : $recipeId;

        $recipe = Recipe::find()
            ->where(['recipes.id' => $recipeId])
            ->one();
        $tags = array_column(ArrayHelper::toArray($recipe->tags), 'id');

        $related = Recipe::find()
            ->leftJoin('ratings', 'recipes.id = ratings.recipe_id')
            ->innerJoin('recipe_tags', 'recipes.id = recipe_tags.recipe_id')
            ->where(['recipe_tags.tag_id' => $tags])
            ->andWhere(['!=' , 'recipes.id', $recipeId])
            ->orderBy([
                'ratings.vote' => SORT_DESC,
                'ratings.rate' => SORT_DESC,
                'ratings.created_at' => SORT_DESC,
            ])
            ->limit($totalMax);

        $totalResult = count($related->all());
        if ($totalResult < $totalMax) {
            $categoryId = $recipe->category->id;
            $additionalTotal = $totalMax - $totalResult;

            $sqlQuery = "
              SELECT * FROM recipes 
              WHERE category_id = :category 
              ORDER BY RAND() LIMIT {$additionalTotal}";

            $additionalQuery = Recipe::findBySql($sqlQuery, [':category' => $categoryId])
                ->createCommand()
                ->getRawSql();

            $related->union($additionalQuery);
        }

        return $related->all();
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
     * @param null $rating
     * @return int|string
     */
    public function getTotalRating($rating = null)
    {
        if (is_null($rating)) {
            return $this->getRatings()->count();
        } else {
            return $this->getRatings()->where(['rate' => $rating])->count();
        }
    }

    /**
     * Get total rating percentage.
     * @param $rating
     * @return float|int
     */
    public function getTotalRatingPercentage($rating)
    {
        $totalRating = $this->getTotalRating();
        $ratingValue = $this->getTotalRating($rating);
        if ($ratingValue == 0) {
            return 0;
        }
        return $ratingValue / $totalRating * 100;
    }

    /**
     * Get latest positive rating.
     * @param null $recipeId
     * @return array|null|ActiveRecord
     */
    public function getRatingPositive($recipeId = null)
    {
        $totalReview = $this->getRatings()
            ->where(['recipe_id' => is_null($recipeId) ? $this->id : $recipeId])
            ->orderBy([
                'ratings.vote' => SORT_DESC,
                'ratings.rate' => SORT_DESC,
                'ratings.created_at' => SORT_DESC,
            ]);

        return $totalReview->one();
    }

    /**
     * Get latest critical rating.
     * @param null $recipeId
     * @return array|null|ActiveRecord
     */
    public function getRatingCritical($recipeId = null)
    {
        $totalReview = $this->getRatings()
            ->where(['recipe_id' => is_null($recipeId) ? $this->id : $recipeId])
            ->orderBy([
                'ratings.vote' => SORT_ASC,
                'ratings.rate' => SORT_ASC,
                'ratings.created_at' => SORT_DESC,
            ]);

        return $totalReview->one();
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
    public function getFavoriters()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('favorites', ['recipe_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCookers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('cookers', ['recipe_id' => 'id']);
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
}
