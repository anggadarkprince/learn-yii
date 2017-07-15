<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

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
 * @property UploadedFile $featureImage
 *
 * @property Direction[] $directions
 * @property Ingredient[] $ingredients
 * @property Rating[] $ratings
 * @property Tag[] $tags
 * @property Recipe[] $relatedRecipes
 * @property Recipe[] $featuredRecipes
 * @property Category $category
 * @property User $user
 */
class Recipe extends ActiveRecord
{
    public $featureImage;

    /**
     * Set default table name.
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'recipes';
    }

    public function init()
    {
        parent::init();

        $this->preparation_time = '00:30';
        $this->cook_time = '02:00';
        $this->servings = 1;
        $this->calories = 250;
        $this->privacy = 'public';
    }

    /**
     * Set recipe data rules.
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'title', 'slug', 'description'], 'required'],
            [['user_id', 'category_id', 'servings', 'calories'], 'integer'],
            [['preparation_time', 'cook_time', 'created_at', 'updated_at'], 'safe'],
            [['title', 'slug', 'description', 'tips'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            [['privacy'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 500],
            [['tips'], 'string', 'max' => 300],
            [['feature'], 'file', 'skipOnEmpty' => true, 'extensions' => 'gif, png, jpg'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * Set recipe attribute label.
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
            'feature' => 'Feature Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Upload feature image.
     * @return bool
     */
    public function uploadFeature()
    {
        if ($this->validate()) {
            $file = mb_ereg_replace("([^A-Za-z\s\d\-_\[\]\(\).])", '', $this->featureImage->baseName);
            $file = mb_ereg_replace("([\.]{2,})", '', $file);
            $fileName = uniqid() . $file . '.' . $this->featureImage->extension;
            $filePath = 'img/recipes/' . $fileName;
            if ($this->featureImage->saveAs($filePath)) {
                $this->feature = $fileName;
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    /**
     * Get featured recipe randomly.
     * @param int $totalMax
     * @return array|ActiveRecord[]
     */
    public function getFeaturedRecipes($totalMax = 4)
    {
        $recipesQuery = Recipe::find()
            ->select(['recipes.id', 'title', 'IFNULL(AVG(ratings.rate), 0) AS rating'])
            ->joinWith('ratings', false)
            ->groupBy('recipes.id')
            ->orderBy(['rating' => SORT_DESC])
            ->limit($totalMax * 2)
            ->createCommand()
            ->getRawSql();

        $randomRecipes = (new Query())
            ->select('id')
            ->from('(' . $recipesQuery . ') AS top_recipes')
            ->orderBy('RAND()')
            ->limit($totalMax)
            ->all();

        return Recipe::find()->where(['in', 'id', $randomRecipes])->all();
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

        /* @var $recipe Recipe */
        $recipe = Recipe::find()->where(['recipes.id' => $recipeId])->one();
        $tags = array_column(ArrayHelper::toArray($recipe->tags), 'id');

        $related = Recipe::find()
            ->leftJoin('ratings', 'recipes.id = ratings.recipe_id')
            ->innerJoin('recipe_tags', 'recipes.id = recipe_tags.recipe_id')
            ->where(['recipe_tags.tag_id' => $tags])
            ->andWhere(['!=', 'recipes.id', $recipeId])
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
              ORDER BY RAND() LIMIT :total";

            $additionalQuery = Recipe::findBySql($sqlQuery, [
                ':category' => $categoryId,
                ':total' => $additionalTotal,
            ]);

            $related->union($additionalQuery->createCommand()->getRawSql());
        }

        return $related->all();
    }

    /**
     * Get recipe directions
     * @return \yii\db\ActiveQuery
     */
    public function getDirections()
    {
        return $this->hasMany(Direction::className(), ['recipe_id' => 'id']);
    }

    /**
     * Get recipe ingredients
     * @return \yii\db\ActiveQuery
     */
    public function getIngredients()
    {
        return $this->hasMany(Ingredient::className(), ['recipe_id' => 'id']);
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
     * Get total rating by value or all review.
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
     * Get recipe ratings data.
     * @return \yii\db\ActiveQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::className(), ['recipe_id' => 'id']);
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
     * Get recipe's tags.
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('recipe_tags', ['recipe_id' => 'id']);
    }

    /**
     * Get user that bookmark as favorite recipe.
     * @return \yii\db\ActiveQuery
     */
    public function getFavoriters()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('favorites', ['recipe_id' => 'id']);
    }

    /**
     * Get user that made of the recipe.
     * @return \yii\db\ActiveQuery
     */
    public function getCookers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('cookers', ['recipe_id' => 'id']);
    }

    /**
     * Get recipe categories
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Get author of recipe.
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
