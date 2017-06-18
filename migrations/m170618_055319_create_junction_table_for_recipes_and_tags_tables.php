<?php

use yii\db\Migration;

/**
 * Handles the creation of table `recipes_tags`.
 * Has foreign keys to the tables:
 *
 * - `recipes`
 * - `tags`
 */
class m170618_055319_create_junction_table_for_recipes_and_tags_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('recipe_tags', [
            'recipe_id' => $this->integer(),
            'tag_id' => $this->integer(),
            'PRIMARY KEY(recipe_id, tag_id)',
        ]);

        // creates index for column `recipe_id`
        $this->createIndex(
            'idx-recipe_tags-recipe_id',
            'recipe_tags',
            'recipe_id'
        );

        // add foreign key for table `recipes`
        $this->addForeignKey(
            'fk-recipe_tags-recipe_id',
            'recipe_tags',
            'recipe_id',
            'recipes',
            'id',
            'CASCADE'
        );

        // creates index for column `tags_id`
        $this->createIndex(
            'idx-recipe_tags-tag_id',
            'recipe_tags',
            'tag_id'
        );

        // add foreign key for table `tags`
        $this->addForeignKey(
            'fk-recipe_tags-tag_id',
            'recipe_tags',
            'tag_id',
            'tags',
            'id',
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
            'fk-recipe_tags-recipe_id',
            'recipe_tags'
        );

        // drops index for column `recipe_id`
        $this->dropIndex(
            'idx-recipe_tags-recipe_id',
            'recipe_tags'
        );

        // drops foreign key for table `tags`
        $this->dropForeignKey(
            'fk-recipe_tags-tag_id',
            'recipe_tags'
        );

        // drops index for column `tag_id`
        $this->dropIndex(
            'idx-recipe_tags-tag_id',
            'recipe_tags'
        );

        $this->dropTable('recipe_tags');
    }
}
