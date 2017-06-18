<?php

use yii\db\Migration;

/**
 * Handles the creation of table `directions`.
 */
class m170618_051014_create_directions_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('directions', [
            'id' => $this->primaryKey(),
            'recipe_id' => $this->integer()->notNull(),
            'direction' => $this->string(700)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `recipe_id`
        $this->createIndex(
            'idx-directions-recipe_id',
            'directions',
            'recipe_id'
        );

        // add foreign key for table `recipes`
        $this->addForeignKey(
            'fk-directions-recipe_id',
            'directions',
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
        // drops foreign key for table `recipes`
        $this->dropForeignKey(
            'fk-directions-recipe_id',
            'ingredients'
        );

        // drops index for column `recipe_id`
        $this->dropIndex(
            'idx-directions-recipe_id',
            'ingredients'
        );

        $this->dropTable('directions');
    }
}
