<?php

declare(strict_types=1);

namespace Test\Functional\Response;

use Application\Infrastructure\Http\Slim\Response\HtmlResponse;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class HtmlResponseTest extends TestCase
{
    public function testDefault(): void
    {
        $response = new HtmlResponse($html = '<html lang="en"></html>');

        self::assertEquals('text/html', $response->getHeaderLine('Content-Type'));
        self::assertEquals($html, $response->getBody()->getContents());
        self::assertEquals(200, $response->getStatusCode());
    }

    public function testWithCode(): void
    {
        $response = new HtmlResponse($html = '<html lang="en"></html>', 201);

        self::assertEquals('text/html', $response->getHeaderLine('Content-Type'));
        self::assertEquals($html, $response->getBody()->getContents());
        self::assertEquals(201, $response->getStatusCode());
    }
}