<?php

declare(strict_types=1);

chdir(dirname(__DIR__));

use Blog\Infrastructure\UI\Web\WebApplication;
use Zend\Diactoros\ServerRequestFactory;
use Zend\ServiceManager\ServiceManager;

/** @var ServiceManager $container */
$container = require 'config/container.php';

/** @var WebApplication $app */
$app = $container->get(WebApplication::class);
$app->run(ServerRequestFactory::fromGlobals());
