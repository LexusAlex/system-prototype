<?php

declare(strict_types=1);

namespace Application\Infrastructure\Http\Slim\Actions;

use Application\Infrastructure\Http\Slim\Response\JsonResponse;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use stdClass;

final class HomeAction implements RequestHandlerInterface
{
    /**
     * @throws JsonException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(new stdClass());
    }
}
