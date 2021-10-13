<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;

http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../configuration/main/container.php';

$application = (require __DIR__ . '/../configuration/main/slim/application.php')($container);

$application->run();
