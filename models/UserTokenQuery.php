<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Article]].
 *
 * @see Article
 */
class UserTokenQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return UserToken[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserToken|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function token($key, $secret)
    {
        return $this->andOnCondition(['key' => $key, 'secret' => $secret]);
    }
}
