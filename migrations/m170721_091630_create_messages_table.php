<?php

use yii\db\Migration;

/**
 * Handles the creation of table `messages`.
 */
class m170721_091630_create_messages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('messages', [
            'id' => $this->primaryKey(),
            'sender_id' => $this->integer(),
            'receiver_id' => $this->integer(),
            'message' => $this->text(),
            'is_available_sender' => $this->boolean()->defaultValue(true),
            'is_available_receiver' => $this->boolean()->defaultValue(true),
            "created_at" => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            "updated_at" => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `sender_id`
        $this->createIndex(
            'idx-messages-sender_id',
            'messages',
            'sender_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-messages-sender_id',
            'messages',
            'sender_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `receiver_id`
        $this->createIndex(
            'idx-followers-receiver_id',
            'messages',
            'receiver_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-followers-receiver_id',
            'messages',
            'receiver_id',
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
        $this->dropTable('messages');
    }
}
