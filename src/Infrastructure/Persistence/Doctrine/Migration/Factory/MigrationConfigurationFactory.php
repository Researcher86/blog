<?php


namespace Blog\Infrastructure\Persistence\Doctrine\Migration\Factory;

use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class MigrationConfigurationFactory
{
    const CONFIGURATION_METHOD_MAP = [
        'migrations_namespace'      => 'setMigrationsNamespace',
        'table_name'                => 'setMigrationsTableName',
        'column_name'               => 'setMigrationsColumnName',
        'column_length'             => 'setMigrationsColumnLength',
        'executed_at_column_name'   => 'setMigrationsExecutedAtColumnName',
        'organize_migrations'       => 'setMigrationOrganization',
        'name'                      => 'setName',
        'migrations_directory'      => '',
        'migrations'                => 'loadMigrations',
        'custom_template'           => 'setCustomTemplate',
        'all_or_nothing'            => 'setAllOrNothing',
    ];


    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get(EntityManagerInterface::class);
        $connection = $em->getConnection();

        $configuration = new Configuration($connection);
        $config = $container->get('config')['doctrine']['migrations'];

        foreach ($config as $key => $value) {
            if (empty($value)) {
                continue;
            }

            if ($key === 'migrations_directory') {
                $configuration->setMigrationsDirectory($config[$key]);
                $configuration->registerMigrationsFromDirectory($config[$key]);
            } else {
                $configuration->{self::CONFIGURATION_METHOD_MAP[$key]}($config[$key]);
            }

        }

        return $configuration;
    }

}