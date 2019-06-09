<?php

use Blog\Domain\Model\User\UserRepository;
use Blog\Infrastructure\Persistence\Doctrine\Domain\Model\User\DoctrineUserRepository;

return [
    'dependencies' => [
        'factories' => [

        ],

        'aliases' => [
            UserRepository::class => DoctrineUserRepository::class,
        ],
    ],

    'debug' => true
];