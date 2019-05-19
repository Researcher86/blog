<?php

/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';
$container->get('fixture-executor')();

