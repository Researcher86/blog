<?php

use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories' => [
            PDO::class => function (ContainerInterface $container, $requestedName) {
                $config = $container->get('config')['pdo'];

                return new \PDO(
                    $config['dsn'],
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
            }
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

    'auth' => [
        'users' => [
            'admin' => 'password',
        ],
    ],
];
