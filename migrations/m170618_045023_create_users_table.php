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
            "cover" => $this->string(300)->notNull()->defaultValue('nocover.jpg'),
            "about" => $this->string(300),
            "location" => $this->string(300),
            "contact" => $this->string(50),
            "auth_key" => $this->string(100),
            "access_token" => $this->string(100),
            "language" => $this->string(100),
            "timezone" => $this->string(100),
            "country" => $this->string(100),
            "relevant_content" => $this->boolean(),
            "login_verification" => $this->boolean(),
            "email_product_offer" => $this->boolean(),
            "email_recipe_feed" => $this->boolean(),
            "email_recipe_recommendation" => $this->boolean(),
            "email_follower" => $this->boolean(),
            "email_message" => $this->boolean(),
            "private_account" => $this->boolean(),
            "private_recipe" => $this->boolean(),
            "tag_location" => $this->boolean(),
            "discoverability" => $this->boolean(),
            "light_mode" => $this->boolean(),
            "status" => "ENUM('pending', 'activated', 'suspended') DEFAULT 'pending'",
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
