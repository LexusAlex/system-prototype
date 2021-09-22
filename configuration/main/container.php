<?php

declare(strict_types=1);

use DI\ContainerBuilder;

$builder = new ContainerBuilder();
$builder->addDefinitions([]);

try {
    return $builder->build();
} catch (Exception $e) {
}
