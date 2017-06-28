<?php

use yii\db\Migration;

/**
 * Handles the creation of table `recipes`.
 */
class m170618_050940_create_recipes_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('recipes', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'title' => $this->string(100)->notNull(),
            'slug' => $this->string(200)->notNull(),
            'description' => $this->string(500)->notNull(),
            'preparation_time' => $this->time()->notNull()->defaultValue(0),
            'cook_time' => $this->time()->notNull()->defaultValue(0),
            'tips' => $this->string(300),
            'servings' => $this->smallInteger()->notNull()->defaultValue(1),
            'calories' => $this->smallInteger()->notNull()->defaultValue(0),
            'privacy' => "ENUM('public', 'private', 'follower')",
            'feature' => $this->string('300')->notNull()->defaultValue('nofeature.jpg'),
            "created_at" => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            "updated_at" => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-recipes-user_id',
            'recipes',
            'user_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-recipes-user_id',
            'recipes',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            'idx-recipes-category_id',
            'recipes',
            'category_id'
        );

        // add foreign key for table `categories`
        $this->addForeignKey(
            'fk-recipes-category_id',
            'recipes',
            'category_id',
            'categories',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-recipes-user_id',
            'recipes'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-recipes-user_id',
            'recipes'
        );

        // drops foreign key for table `categories`
        $this->dropForeignKey(
            'fk-categories-category_id',
            'recipes'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-categories-category_id',
            'recipes'
        );

        $this->dropTable('recipes');
    }
}
