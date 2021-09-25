<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/../environments/common/*.php'),
    new PhpFileProvider(__DIR__ . '/../environments/' . (getenv('APPLICATION_ENVIRONMENT') ?: 'production') . '/*.php'),
]);

return $aggregator->getMergedConfig();
