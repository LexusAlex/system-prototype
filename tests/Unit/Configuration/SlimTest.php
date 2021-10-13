<?php

declare(strict_types=1);

namespace Test\Unit\Configuration;

use DI\Container;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

/**
 * @internal
 */
final class SlimTest extends TestCase
{
    public function testCreateFromContainer(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';

        $application = (require __DIR__ . '/../../../configuration/main/slim/application.php')($container);

        self::assertInstanceOf(Container::class, $application->getContainer());

    }
}
