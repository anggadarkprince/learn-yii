<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yummy',
    'username' => 'root',
    'password' => 'anggaari',
    'charset' => 'utf8',
    'on afterOpen' => function($event) {
        // $event->sender refers to the DB connection
        $event->sender->createCommand("SET time_zone = '+07:00'")->execute();
    }
];
