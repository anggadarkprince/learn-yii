<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Article]].
 *
 * @see Article
 */
class ArticleQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Article[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Article|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function status($state = 'published')
    {
        return $this->andOnCondition(['status' => $state]);
    }

    public function published()
    {
        return $this->andOnCondition(['status' => Article::$STATUS_PUBLISHED]);
    }

    public function draft()
    {
        return $this->andOnCondition(['status' => Article::$STATUS_DRAFT]);
    }

    public function latest()
    {
        return $this->orderBy(['created_at' => SORT_DESC]);
    }
}
