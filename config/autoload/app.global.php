<?php

use Blog\Application\Service\ApplicationService;
use Blog\Application\Service\User\GetAllUsersService;
use Blog\Domain\Model\User\UserRepository;
use Blog\Infrastructure\Persistence\Doctrine\Domain\Model\User\DoctrineUserRepository;

return [
    'dependencies' => [
        'factories' => [

        ],

        'aliases' => [
            UserRepository::class => DoctrineUserRepository::class,
            ApplicationService::class => GetAllUsersService::class,
        ],
    ],

    'debug' => true
];