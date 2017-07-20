<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

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
 * @property string $language
 * @property string $country
 * @property string $timezone
 * @property string $relevant_content
 * @property string $login_notification
 * @property string $login_verification
 * @property string $email_product_offer
 * @property string $email_recipe_feed
 * @property string $email_recipe_recommendation
 * @property string $email_follower
 * @property string $email_message
 * @property string $private_account
 * @property string $private_recipe
 * @property string $tag_location
 * @property string $discoverability
 * @property string $light_mode
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

    const SCENARIO_SETTING_APPLICATION = 'setting-application';
    const SCENARIO_SETTING_PROFILE = 'setting-profile';
    const SCENARIO_SETTING_PASSWORD = 'setting-password';
    const SCENARIO_SETTING_SECURITY = 'setting-security';
    const SCENARIO_SETTING_NOTIFICATION = 'setting-notification';
    const SCENARIO_SETTING_PRIVACY = 'setting-privacy';
    const SCENARIO_SETTING_ACCESSIBILITY = 'setting-accessibility';

    public $avatarImage;
    public $coverImage;
    public $old_password;
    public $new_password;
    public $confirm_password;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SETTING_APPLICATION] = [
            'language', 'timezone', 'country', 'relevant_content'
        ];
        $scenarios[self::SCENARIO_SETTING_PROFILE] = [
            'name', 'username', 'email', 'location', 'about', 'contact', 'avatar', 'feature'
        ];
        $scenarios[self::SCENARIO_SETTING_PASSWORD] = [
            'password', 'old_password', 'new_password', 'confirm_password'
        ];
        $scenarios[self::SCENARIO_SETTING_SECURITY] = [
            'login_notification', 'login_verification'
        ];
        $scenarios[self::SCENARIO_SETTING_NOTIFICATION] = [
            'email_product_offer', 'email_recipe_feed', 'email_recipe_recommendation', 'email_follower', 'email_message'
        ];
        $scenarios[self::SCENARIO_SETTING_PRIVACY] = [
            'private_account', 'private_recipe', 'tag_location'
        ];
        $scenarios[self::SCENARIO_SETTING_ACCESSIBILITY] = [
            'private_account', 'private_recipe', 'tag_location', 'discoverability'
        ];
        $scenarios[self::SCENARIO_SETTING_ACCESSIBILITY] = [
            'light_mode'
        ];
        return $scenarios;
    }

    /**
     * Set default table name.
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'username', 'email', 'password', 'old_password'], 'required'],
            [['status'], 'string'],
            [['relevant_content', 'login_notification', 'login_verification', 'email_product_offer', 'email_recipe_feed', 'email_recipe_recommendation', 'email_follower', 'email_message', 'private_account', 'private_recipe', 'tag_location', 'discoverability', 'light_mode'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'username', 'email', 'contact'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 150],
            [['avatar', 'cover', 'location'], 'string', 'max' => 300],
            [['avatarImage', 'coverImage'], 'file', 'skipOnEmpty' => false, 'extensions' => 'gif, png, jpg'],
            [['about'], 'string', 'max' => 500],
            [['auth_key', 'access_token', 'language', 'country', 'timezone'], 'string', 'max' => 100],
            [['username'], 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => ['username'], 'message' => 'Username must be unique.'],
            [['email'], 'unique', 'targetClass' => 'app\models\User', 'targetAttribute' => ['email'], 'message' => 'Email must be unique.'],
            ['username', 'match', 'pattern' => '/^[A-Za-z0-9_-]{3,15}$/', 'message' => 'Your username can only contain alphanumeric characters, underscores and dashes.'],
            ['old_password', function ($attribute, $params, $validator) {
                if (!$this->validatePassword($this->$attribute)) {
                    $this->addError($attribute, 'The password is mismatch with current password.');
                }
            }, 'on' => self::SCENARIO_SETTING_PASSWORD],
            ['new_password', 'string', 'min' => 6, 'on' => self::SCENARIO_SETTING_PASSWORD],
            [['new_password', 'confirm_password'], 'required', 'on' => self::SCENARIO_SETTING_PASSWORD],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => "New passwords don't match"],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'avatar' => 'Avatar',
            'cover' => 'Cover',
            'location' => 'Location',
            'contact' => 'Contact',
            'about' => 'About',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'status' => 'Status',
            'language' => 'Language',
            'country' => 'Country',
            'timezone' => 'Timezone',
            'relevant_content' => 'Relevant Content',
            'login_notification' => 'Login Notification',
            'login_verification' => 'Login Verification',
            'email_product_offer' => 'Email Product Offer',
            'email_recipe_feed' => 'Email Recipe Feed',
            'email_recipe_recommendation' => 'Email Recipe Recommendation',
            'email_follower' => 'Email Follower',
            'email_message' => 'Email Message',
            'private_account' => 'Private Account',
            'private_recipe' => 'Private Recipe',
            'tag_location' => 'Tag Location',
            'discoverability' => 'Discoverability',
            'light_mode' => 'Light Mode',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
     * Get full url of avatar.
     * @return string
     */
    public function getAvatarUrl()
    {
        return Url::to("/img/avatars/{$this->avatar}");
    }

    /**
     * Set full url of avatar.
     * @param $value
     */
    public function setAvatarUrl($value)
    {
        $this->avatar = end(explode('/', $value));
    }


    /**
     * Get full url of avatar.
     * @return string
     */
    public function getCoverUrl()
    {
        return Url::to("/img/covers/{$this->avatar}");
    }

    /**
     * Set full url of avatar.
     * @param $value
     */
    public function setCoverUrl($value)
    {
        $this->cover = end(explode('/', $value));
    }

    /**
     * Upload avatar and feature image.
     * @param $source UploadedFile
     * @param $filePath
     * @param $fileName
     * @return bool
     */
    public function uploadImage($source, $filePath, $fileName)
    {
        if ($this->validate()) {
            $fileName = $fileName . '.' . $source->extension;
            $filePath = $filePath . $fileName;
            if ($source->saveAs($filePath)) {
                return $fileName;
            }
            return false;
        } else {
            return false;
        }
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
     * Get user that following us.
     * @param null $totalMax
     * @return \yii\db\ActiveQuery|ActiveRecord[]
     */
    public function getFollowings($totalMax = null)
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
     * Get user followers.
     * @param null $max
     * @return \yii\db\ActiveQuery|ActiveRecord[]
     */
    public function getFollowers($max = null)
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
     * Check if current user is following an user.
     * @param $userId
     * @return bool
     */
    public function isFollow($userId)
    {
        if (Yii::$app->user->isGuest) {
            return -1;
        }
        $isFollowing = $this->getFollowings()->where(['id' => $userId])->count();
        if ($isFollowing > 0) {
            return 1;
        }
        return 0;
    }

    /**
     * Get recipe that loved by user.
     * @return \yii\db\ActiveQuery
     */
    public function getFavorites()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])
            ->viaTable('favorites', ['user_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * Get recipe that cooked by user.
     * @return \yii\db\ActiveQuery
     */
    public function getCooks()
    {
        return $this->hasMany(Recipe::className(), ['id' => 'recipe_id'])
            ->viaTable('cookers', ['user_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * Search user by name, email or username
     * @param $query
     * @return array|ActiveRecord[]
     */
    public function search($query)
    {
        return self::find()
            ->where(['like', 'name', $query])
            ->orWhere(['like', 'username', $query])
            ->orWhere(['like', 'email', $query]);
    }
}
