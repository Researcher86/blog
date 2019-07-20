<?php

use Blog\Domain\Model\User\UserRepository;
use Blog\Domain\Model\Post\PostRepository;
use Blog\Infrastructure\Persistence\Doctrine\Domain\Model\User\DoctrineUserRepository;
use Blog\Infrastructure\Persistence\Doctrine\Domain\Model\Post\DoctrinePostRepository;

return [
    'dependencies' => [
        'factories' => [

        ],

        'aliases' => [
            UserRepository::class => DoctrineUserRepository::class,
            PostRepository::class => DoctrinePostRepository::class,
        ],
    ],

    'debug' => true
];
