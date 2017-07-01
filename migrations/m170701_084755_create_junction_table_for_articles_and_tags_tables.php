<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_tags`.
 * Has foreign keys to the tables:
 *
 * - `articles`
 * - `tags`
 */
class m170701_084755_create_junction_table_for_articles_and_tags_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_tags', [
            'article_id' => $this->integer(),
            'tag_id' => $this->integer(),
            'created_at' => $this->dateTime(),
            'PRIMARY KEY(article_id, tag_id)',
        ]);

        // creates index for column `article_id`
        $this->createIndex(
            'idx-article_tags-articles_id',
            'article_tags',
            'article_id'
        );

        // add foreign key for table `articles`
        $this->addForeignKey(
            'fk-article_tags-article_id',
            'article_tags',
            'article_id',
            'articles',
            'id',
            'CASCADE'
        );

        // creates index for column `tag_id`
        $this->createIndex(
            'idx-article_tags-tag_id',
            'article_tags',
            'tag_id'
        );

        // add foreign key for table `tags`
        $this->addForeignKey(
            'fk-article_tags-tag_id',
            'article_tags',
            'tag_id',
            'tags',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `articles`
        $this->dropForeignKey(
            'fk-article_tags-article_id',
            'article_tags'
        );

        // drops index for column `article_id`
        $this->dropIndex(
            'idx-article_tags-article_id',
            'article_tags'
        );

        // drops foreign key for table `tags`
        $this->dropForeignKey(
            'fk-article_tags-tag_id',
            'article_tags'
        );

        // drops index for column `tags_id`
        $this->dropIndex(
            'idx-article_tags-tag_id',
            'article_tags'
        );

        $this->dropTable('article_tags');
    }
}
