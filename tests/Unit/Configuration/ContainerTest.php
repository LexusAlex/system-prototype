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
        self::assertIsObject(require __DIR__ . '/../../../configuration/main/container.php');
    }
}
