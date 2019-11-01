<?php

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Tools\Console\Helper\ConfigurationHelper;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

require 'vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';
$em = $container->get(EntityManagerInterface::class);

return new HelperSet([
    'em' => new EntityManagerHelper($em),
    'db' => new ConnectionHelper($em->getConnection()),
    'configuration' => new ConfigurationHelper(
        $em->getConnection(),
        $container->get(Configuration::class)
    ),
]);
