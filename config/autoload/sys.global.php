<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

return [
    'dependencies' => [
        'factories' => [
            Logger::class => function (ContainerInterface $container, $requestedName) {
                return new Logger('blog', [
                    new StreamHandler('storage/app.log', Logger::WARNING),
//                    new NativeMailerHandler('', '', '', Logger::ERROR)
                ]);
            },
        ],

        'aliases' => [
            LoggerInterface::class => Logger::class,
        ],

        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
    ],
];