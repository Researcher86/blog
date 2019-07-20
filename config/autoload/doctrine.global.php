<?php

use ContainerInteropDoctrine\EntityManagerFactory;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories'  => [
            EntityManagerInterface::class => EntityManagerFactory::class,
            Doctrine\Migrations\Configuration\Configuration::class => Blog\Infrastructure\Persistence\Doctrine\Migration\Factory\MigrationConfigurationFactory::class,

            'fixture-executor' => function (ContainerInterface $container, $requestedName) {
                return function () use ($container) {
                    $loader = new Loader();
                    $loader->loadFromDirectory($container->get('config')['doctrine']['fixtures']['path']);
                    $executor = new ORMExecutor($container->get(EntityManagerInterface::class), new ORMPurger());

                    $executor->execute($loader->getFixtures());
                };
            }
        ],
    ],

    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'result_cache' => 'filesystem',
                'metadata_cache' => 'filesystem',
                'query_cache' => 'filesystem',
                'hydration_cache' => 'filesystem',
            ],
        ],
        'connection' => [
            'orm_default' => [
                'driver_class' => \Doctrine\DBAL\Driver\PDOSqlite\Driver::class,
                'pdo' => PDO::class,
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    'Blog\Domain\Model' => 'entities',
                ],
            ],
            'entities' => [
                'class' => Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'filesystem',
                'paths' => ['src/Domain/Model'],
            ],
        ],
        'cache' => [
            'filesystem' => [
                'class' => Doctrine\Common\Cache\FilesystemCache::class,
                'directory' => 'storage/cache/doctrine',
            ],
        ],

        'migrations' => [
            'name' => 'Blog Migrations',
            'migrations_namespace' => 'Blog\Infrastructure\Persistence\Doctrine\Migration',
            'table_name' => 'doctrine_migration_versions',
            'column_name' => 'version',
            'column_length' => 14,
            'executed_at_column_name' => 'executed_at',
            'migrations_directory' => 'src/Infrastructure/Persistence/Doctrine/Migration',
            'all_or_nothing' => true,
        ],

        'fixtures' => [
            'path' => 'src/Infrastructure/Persistence/Doctrine/Fixture'
        ]
    ],
];
