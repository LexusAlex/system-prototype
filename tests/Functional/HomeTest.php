<?php

declare(strict_types=1);

namespace Test\Functional;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Factory\ServerRequestFactory;

/**
 * @internal
 */
final class HomeTest extends TestCase
{
    /**
     * @throws \JsonException
     */
    public function testSuccessHomePage(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../configuration/main/container.php';

        $application = (require __DIR__ . '/../../configuration/main/slim/application.php')($container);

        $request = (new ServerRequestFactory())->createServerRequest("GET", '/')->withHeader('Accept', 'application/json')->withHeader('Content-Type', 'application/json');

        $response = $application->handle($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('application/json', $response->getHeaderLine('Content-Type'));
        self::assertEquals('{}', (string)$response->getBody());
    }

    public function testMethodHomePage(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../configuration/main/container.php';

        $application = (require __DIR__ . '/../../configuration/main/slim/application.php')($container);

        $request = (new ServerRequestFactory())->createServerRequest("DELETE", '/')->withHeader('Accept', 'application/json')->withHeader('Content-Type', 'application/json');

        $response = $application->handle($request);

        self::assertEquals(405, $response->getStatusCode());
    }
}