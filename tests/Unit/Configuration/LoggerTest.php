<?php

declare(strict_types=1);

namespace Test\Unit\Configuration;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * @internal
 */
final class LoggerTest extends TestCase
{
    public function testCreateContainer(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';
        /** @var Logger $logger */
        $logger = $container->get(LoggerInterface::class);
        self::assertEquals("API", $logger->getName());
    }
}