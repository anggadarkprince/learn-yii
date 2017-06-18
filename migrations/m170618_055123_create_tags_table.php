<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tags`.
 */
class m170618_055123_create_tags_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('tags', [
            'id' => $this->primaryKey(),
            'tag' => $this->string(50)->notNull(),
            'slug' => $this->string(100)->notNull(),
            "created_at" => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            "updated_at" => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-tags-slug',
            'tags',
            'slug'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        // drops index for column `slug`
        $this->dropIndex(
            'idx-tags-slug',
            'tags'
        );

        $this->dropTable('tags');
    }
}
