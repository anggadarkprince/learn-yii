<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cookers`.
 */
class m170629_123559_create_cookers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cookers', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'recipe_id' => $this->integer()->notNull(),
            'description' => $this->string(300),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-cookers-user_id',
            'cookers',
            'user_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-cookers-user_id',
            'cookers',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `recipe_id`
        $this->createIndex(
            'idx-cookers-recipe_id',
            'cookers',
            'recipe_id'
        );

        // add foreign key for table `recipes`
        $this->addForeignKey(
            'fk-cookers-recipe_id',
            'cookers',
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
            'fk-cookers-user_id',
            'cookers'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-cookers-user_id',
            'cookers'
        );

        // drops foreign key for table `recipes`
        $this->dropForeignKey(
            'fk-cookers-recipe_id',
            'cookers'
        );

        // drops index for column `recipe_id`
        $this->dropIndex(
            'idx-cookers-recipe_id',
            'cookers'
        );

        $this->dropTable('cookers');
    }
}
