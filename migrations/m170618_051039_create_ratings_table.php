<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ratings`.
 */
class m170618_051039_create_ratings_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('ratings', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'recipe_id' => $this->integer()->notNull(),
            'rate' => $this->smallInteger()->notNull()->defaultValue(3),
            'review' => $this->string(500)->notNull(),
            'vote' => $this->integer()->notNull()->defaultValue(0),
            "created_at" => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            "updated_at" => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-ratings-user_id',
            'ratings',
            'user_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-ratings-user_id',
            'ratings',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `recipe_id`
        $this->createIndex(
            'idx-ratings-recipe_id',
            'ratings',
            'recipe_id'
        );

        // add foreign key for table `recipes`
        $this->addForeignKey(
            'fk-ratings-recipe_id',
            'ratings',
            'recipe_id',
            'recipes',
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
            'fk-ratings-user_id',
            'ratings'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-ratings-user_id',
            'ratings'
        );

        // drops foreign key for table `recipes`
        $this->dropForeignKey(
            'fk-ratings-recipe_id',
            'ratings'
        );

        // drops index for column `recipe_id`
        $this->dropIndex(
            'idx-ratings-recipe_id',
            'ratings'
        );

        $this->dropTable('ratings');
    }
}
