<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m170618_045023_create_users_table extends Migration
{
    public function safeUp()
    {
        $this->createTable("users", [
            "id" => $this->primaryKey(),
            "name" => $this->string(50)->notNull(),
            "username" => $this->string(50)->notNull()->unique(),
            "email" => $this->string(50)->notNull()->unique(),
            "password" => $this->string(150)->notNull(),
            "avatar" => $this->string(300)->notNull()->defaultValue('noavatar.jpg'),
            "about" => $this->string(300),
            "location" => $this->string(300),
            "contact" => $this->string(50),
            "auth_key" => $this->string(100),
            "access_token" => $this->string(100),
            "created_at" => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            "updated_at" => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-users-username',
            'users',
            'username'
        );

        $this->batchInsert("users", [
            "name", "username", "email", "password", "avatar", "location", "contact"
        ], [
            [
                "Angga Ari Wijaya",
                "anggadarkprince",
                "anggadarkprince@gmail.com",
                password_hash('angga1234', PASSWORD_BCRYPT),
                "noavatar.jpg",
                "Gresik, Indonesia",
                "+6285655479868"
            ],
            [
                "Hana Riyana Ayu",
                "hana",
                "hana@gmail.com",
                password_hash('hana1234', PASSWORD_BCRYPT),
                "noavatar.jpg",
                "Surabaya, Indonesia",
                "+6285655470000"
            ]
        ]);
    }

    public function safeDown()
    {
        $this->dropIndex(
            'idx-users-username',
            'users'
        );

        $this->dropTable('user');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170618_045023_users cannot be reverted.\n";

        return false;
    }
    */
}
