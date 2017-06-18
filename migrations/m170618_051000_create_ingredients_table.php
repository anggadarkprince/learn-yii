<?php

use yii\db\Migration;

/**
 * Handles the creation of table `ingredients`.
 */
class m170618_051000_create_ingredients_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('ingredients', [
            'id' => $this->primaryKey(),
            'recipe_id' => $this->integer()->notNull(),
            'ingredient' => $this->string(500)->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `recipe_id`
        $this->createIndex(
            'idx-ingredients-recipe_id',
            'ingredients',
            'recipe_id'
        );

        // add foreign key for table `recipes`
        $this->addForeignKey(
            'fk-ingredients-recipe_id',
            'ingredients',
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
            'fk-ingredients-recipe_id',
            'ingredients'
        );

        // drops index for column `recipe_id`
        $this->dropIndex(
            'idx-ingredients-recipe_id',
            'ingredients'
        );

        $this->dropTable('ingredients');
    }
}
