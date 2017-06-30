<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $avatar
 * @property string $cover
 * @property string $location
 * @property string $about
 * @property string $contact
 * @property string $created_at
 *
 * @property Recipe[] $recipes
 * @property Rating[] $ratings
 * @property User[] $followers
 * @property User[] $followings
 * @property User[] $favorites
 * @property User[] $cooked
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'name' => 'Angga Ari',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'name' => 'Angga Ari',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    /**
     * Set default table name.
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * Filter object fields.
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();

        // remove fields that contain sensitive information
        unset($fields['password'], $fields['auth_key'], $fields['access_token']);

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return array|null|ActiveRecord
     */
    public static function findByUsername($username)
    {
        return User::find()->where(['username' => $username])->one();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['user_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * Get user followers.
     * @param null $max
     * @return \yii\db\ActiveQuery|ActiveRecord[]
     */
    public function getFollowers($max = null)
    {
        $followersUser = $this->hasMany(User::className(), ['id' => 'following_id'])
            ->viaTable('followers', ['user_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);

        if (!is_null($max)) {
            return $followersUser->limit($max)->all();
        }
        return $followersUser;
    }

    /**
     * Get user that following us.
     * @param null $max
     * @return \yii\db\ActiveQuery|ActiveRecord[]
     */
    public function getFollowings($max = null)
    {
        $followingsUser = $this->hasMany(User::className(), ['id' => 'user_id'])
            ->viaTable('followers', ['following_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);

        if (!is_null($max)) {
            return $followingsUser->limit($max)->all();
        }
        return $followingsUser;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])
            ->viaTable('favorites', ['user_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCooks()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])
            ->viaTable('cookers', ['user_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }
}
