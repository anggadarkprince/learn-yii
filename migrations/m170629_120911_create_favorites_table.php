<?php

use yii\db\Migration;

/**
 * Handles the creation of table `favorites`.
 */
class m170629_120911_create_favorites_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('favorites', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'recipe_id' => $this->integer()->notNull(),
            'description' => $this->string(300),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-favorites-user_id',
            'favorites',
            'user_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-favorites-user_id',
            'favorites',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `recipe_id`
        $this->createIndex(
            'idx-favorites-recipe_id',
            'favorites',
            'recipe_id'
        );

        // add foreign key for table `recipes`
        $this->addForeignKey(
            'fk-favorites-recipe_id',
            'favorites',
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
    public function down()
    {
        // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-favorites-user_id',
            'favorites'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-favorites-user_id',
            'favorites'
        );

        // drops foreign key for table `recipes`
        $this->dropForeignKey(
            'fk-favorites-recipe_id',
            'favorites'
        );

        // drops index for column `recipe_id`
        $this->dropIndex(
            'idx-favorites-recipe_id',
            'favorites'
        );

        $this->dropTable('favorites');
    }
}
