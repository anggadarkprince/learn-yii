<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Categories]].
 *
 * @see Category
 */
class CategoryQuery extends ActiveQuery
{
    /**
     * Get all categories data.
     * @param null $db
     * @return Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * Get single category data.
     * @param null $db
     * @return Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
