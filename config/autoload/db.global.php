<?php

return [
    'dependencies' => [
        'factories' => [
            PDO::class => Infrastructure\App\PDOFactory::class,
        ]
    ],

    'pdo' => [
      'dsn' => 'sqlite:db/db.sqlite',
      'username' => '',
      'password' => '',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ],
];
