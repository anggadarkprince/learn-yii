<?php

use yii\db\Migration;

/**
 * Handles the creation of table `articles`.
 */
class m170701_084344_create_articles_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('articles', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'title' => $this->string(200)->notNull(),
            'slug' => $this->string(400)->notNull(),
            'content' => $this->text()->notNull(),
            'feature' => $this->string(300)->defaultValue('nofeature.jpg'),
            'excerpt' => $this->string(500),
            'status' => "ENUM('draft', 'published') DEFAULT 'draft'",
            'format' => "ENUM('standard', 'image', 'video') DEFAULT 'standard'",
            'view' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-articles-user_id',
            'articles',
            'user_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-articles-user_id',
            'articles',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            'idx-articles-category_id',
            'articles',
            'category_id'
        );

        // add foreign key for table `categories`
        $this->addForeignKey(
            'fk-articles-category_id',
            'articles',
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
            'fk-articles-user_id',
            'articles'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-articles-user_id',
            'articles'
        );

        // drops foreign key for table `categories`
        $this->dropForeignKey(
            'fk-articles-category_id',
            'articles'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            'idx-articles-category_id',
            'articles'
        );

        $this->dropTable('articles');
    }
}
