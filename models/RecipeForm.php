<?php

namespace app\models;


use yii\base\Model;

class RecipeForm extends Model
{
    public $title;
    public $slug;
    public $description;
    public $preparation_time = '00:30:00';
    public $cook_time = '02:00:00';
    public $servings = 1;
    public $calories = 100;
    public $privacy = 'public';
    public $tips;
    public $category_id;
    public $user_id;

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
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
}