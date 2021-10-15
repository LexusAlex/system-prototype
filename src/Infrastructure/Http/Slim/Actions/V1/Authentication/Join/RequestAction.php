<?php

declare(strict_types=1);

namespace Application\Infrastructure\Http\Slim\Actions\V1\Authentication\Join;

use Application\Infrastructure\Http\Slim\Response\EmptyResponse;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestAction implements RequestHandlerInterface
{
    /**
     * @throws JsonException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Здесь уже точка слоя приложения, для этого нужно написать команды
        return new EmptyResponse(201);
    }
}
