<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_tokens`.
 */
class m170706_123605_create_user_tokens_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('user_tokens', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'key' => $this->string(100)->notNull(),
            'secret' => $this->string(100),
            'type' => "ENUM('registration', 'password', 'twitter', 'facebook', 'google')",
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_tokens-user_id',
            'user_tokens',
            'user_id'
        );

        // add foreign key for table `user_tokens`
        $this->addForeignKey(
            'fk-user_tokens-user_id',
            'user_tokens',
            'user_id',
            'users',
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
            'fk-user_tokens-user_id',
            'user_tokens'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_tokens-user_id',
            'user_tokens'
        );

        $this->dropTable('user_tokens');
    }
}
