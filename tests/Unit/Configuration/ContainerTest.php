<?php

declare(strict_types=1);

namespace Test\Unit\Configuration;

use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ContainerTest extends TestCase
{
    public function testCreateContainer(): void
    {
        $container = require __DIR__ . '/../../../configuration/main/container.php';
        self::assertIsObject($container);
        self::assertEquals('DI\Container', $container::class);
    }
}
