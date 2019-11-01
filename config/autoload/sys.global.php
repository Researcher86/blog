<?php

use Blog\Infrastructure\Application\ApplicationAspectKernel;
use Blog\Infrastructure\Application\Service\DoctrineTransactionalAspect;
use Blog\Infrastructure\Application\Service\MonitorAspect;
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
                    new StreamHandler('storage/app.log', $container->get('config')['debug'] ? Logger::DEBUG : Logger::WARNING),
//                    new NativeMailerHandler('', '', '', Logger::ERROR)
                ]);
            },

            ApplicationAspectKernel::class => function (ContainerInterface $container, $requestedName) {
                $cacheDir = 'storage/cache/aop';

                if (! file_exists($cacheDir) && ! mkdir($cacheDir, 0777, true) && ! is_dir($cacheDir)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $cacheDir));
                }
                // Initialize an application aspect container
                $applicationAspectKernel = ApplicationAspectKernel::getInstance();
                $applicationAspectKernel->setDiContainer($container);
                $applicationAspectKernel->init([
                    'debug'        => true, // use 'false' for production mode
                    'appDir'       => 'src/', // Application root directory
                    'cacheDir'     => $cacheDir, // Cache directory
                    // Include paths restricts the directories where aspects should be applied, or empty for all source files
                    'includePaths' => [
                        'src/Application',
                    ],
                ]);

                return $applicationAspectKernel;
            },

            'aspects' => function (ContainerInterface $container, $requestedName) {
                return [
                    $container->get(MonitorAspect::class),
                    $container->get(DoctrineTransactionalAspect::class),
                ];
            },

            'init' => function (ContainerInterface $container, $requestedName) {
                $container->get(ApplicationAspectKernel::class);
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
