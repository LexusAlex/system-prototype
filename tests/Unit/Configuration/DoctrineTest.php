<?php

declare(strict_types=1);

namespace Test\Unit\Configuration;

use Doctrine\DBAL\Connection;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @internal
 */
final class DoctrineTest extends TestCase
{
    public function testTestConnection(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';
        self::assertTrue($container->get(Connection::class)->connect());
    }
}
