<?php

use yii\db\Migration;

/**
 * Handles the creation of table `followers`.
 */
class m170618_054712_create_followers_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('followers', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'following_id' => $this->integer()->notNull(),
            "created_at" => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-followers-user_id',
            'followers',
            'user_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-followers-user_id',
            'followers',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // creates index for column `following_id`
        $this->createIndex(
            'idx-followers-following_id',
            'followers',
            'following_id'
        );

        // add foreign key for table `users`
        $this->addForeignKey(
            'fk-followers-following_id',
            'followers',
            'following_id',
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
            'fk-followers-user_id',
            'followers'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-followers-user_id',
            'followers'
        );

        // drops foreign key for table `users`
        $this->dropForeignKey(
            'fk-followers-following_id',
            'followers'
        );

        // drops index for column `following_id`
        $this->dropIndex(
            'idx-followers-following_id',
            'followers'
        );

        $this->dropTable('followers');
    }
}
