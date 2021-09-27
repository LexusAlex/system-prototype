#!/usr/bin/env php
<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

require __DIR__ . '/../vendor/autoload.php';

$cli = new Application('Symfony console application');

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../configuration/main/container.php';
/**
 * @var string[] $commands
 * @psalm-suppress MixedArrayAccess
 */
$commands = $container->get('configuration')['console']['commands'];

//$entityManager = $container->get(EntityManagerInterface::class);
//$cli->getHelperSet()->set(new EntityManagerHelper($entityManager), 'em');

foreach ($commands as $name) {
    /** @var Command $command */
    $command = $container->get($name);
    $cli->add($command);
}
try {
    $cli->run();
} catch (Exception $e) {
}
