<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
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
 * @property string $auth_key
 * @property string $access_token
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UserToken[] $tokens
 * @property Recipe[] $recipes
 * @property Rating[] $ratings
 * @property User[] $followers
 * @property User[] $followings
 * @property User[] $favorites
 * @property User[] $cooked
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVATED = 'activated';
    const STATUS_SUSPENDED = 'suspended';

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

    public function getAvatarUrl()
    {
        return Url::to("/img/avatars/{$this->avatar}");
    }

    public function setAvatarUrl($value)
    {
        $this->avatar = end(explode('/', $value));
    }

    /**
     * Perform action before create new user.
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->access_token = Yii::$app->security->generateRandomString(64);
            }
            return true;
        }
        return false;
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @param null $type
     * @return null|IdentityInterface the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return User|ActiveRecord
     */
    public static function findByUsername($username)
    {
        return static::find()->where(['username' => $username])->one();
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return User|ActiveRecord
     */
    public static function findByEmail($email)
    {
        return static::find()->where(['email' => $email])->one();
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }

    /**
     * Get user tokens.
     * @return \yii\db\ActiveQuery
     */
    public function getTokens()
    {
        return $this->hasMany(UserToken::className(), ['user_id' => 'id']);
    }

    /**
     * Get user recipes.
     * @return \yii\db\ActiveQuery
     */
    public function getRecipes()
    {
        return $this->hasMany(Recipe::className(), ['user_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * Get user followers.
     * @param null $totalMax
     * @return \yii\db\ActiveQuery|ActiveRecord[]
     */
    public function getFollowers($totalMax = null)
    {
        $followersUser = $this->hasMany(User::className(), ['id' => 'following_id'])
            ->viaTable('followers', ['user_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);

        if (!is_null($totalMax)) {
            return $followersUser->limit($totalMax)->all();
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
