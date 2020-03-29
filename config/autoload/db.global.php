<?php

return [
    'dependencies' => [
        'factories' => [
            PDO::class => Infrastructure\App\PDOFactory::class,
        ]
    ],

    'pdo' => [
        // 'dsn' => 'mysql:host=localhost;port=3306;dbname=app;charset=utf8mb4',
        'dsn' => 'sqlite:db/db.sqlite',
        'username' => 'root',
        'password' => '123456',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ],
];
