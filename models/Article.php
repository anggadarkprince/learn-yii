<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\BaseStringHelper;

/**
 * This is the model class for table "articles".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $feature
 * @property string $excerpt
 * @property string $status
 * @property string $format
 * @property integer $view
 * @property string $created_at
 * @property string $updated_at
 * @property string $publishedAt
 * @property string $summary
 *
 * @property Tag[] $tags
 * @property Category $category
 * @property User $user
 */
class Article extends ActiveRecord
{
    public static $STATUS_PUBLISHED = 'published';
    public static $STATUS_DRAFT = 'draft';

    public $archiveYear;
    public $archiveMonth;
    public $archiveLabel;
    public $totalArticle;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'category_id', 'title', 'slug', 'content'], 'required'],
            [['user_id', 'category_id', 'view'], 'integer'],
            [['content', 'status', 'format', 'feature'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 200],
            [['slug'], 'string', 'max' => 400],
            [['excerpt'], 'string', 'max' => 500],
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
            'user_id' => 'Author',
            'category_id' => 'Category',
            'title' => 'Title',
            'slug' => 'Slug',
            'content' => 'Content',
            'feature' => 'Feature',
            'excerpt' => 'Excerpt',
            'status' => 'Status',
            'format' => 'Format',
            'view' => 'View',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Get published date friendly format.
     * @return string
     */
    public function getPublishedAt()
    {
        return (new \DateTime($this->created_at))->format('d F Y H:i');
    }

    /**
     * Get summary excerpt
     * @return string
     */
    public function getSummary()
    {
        return BaseStringHelper::truncateWords(strip_tags($this->content), 50);
    }

    public function getRecentPost($totalMax = 6)
    {
        return self::find()
            ->latest()
            ->status(self::$STATUS_PUBLISHED)
            ->limit($totalMax)
            ->all();
    }

    public function getArchiveGroups()
    {
        return self::find()
            ->select([
                'DATE_FORMAT(created_at, "%Y") AS archiveYear',
                'DATE_FORMAT(created_at, "%m") AS archiveMonth',
                'DATE_FORMAT(created_at, "%M %Y") AS archiveLabel',
                'COUNT(id) AS totalArticle'
            ])
            ->groupBy([
                'DATE_FORMAT(created_at, "%Y")',
                'DATE_FORMAT(created_at, "%m")',
                'DATE_FORMAT(created_at, "%M %Y")'
            ])
            ->orderBy([
                'archiveYear' => SORT_DESC,
                'archiveMonth' => SORT_DESC
            ])
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('article_tags', ['article_id' => 'id']);
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
     * @return ArticlesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticlesQuery(get_called_class());
    }
}
