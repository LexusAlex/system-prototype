<?php

declare(strict_types=1);

namespace Application\Infrastructure\Http\Slim\Response;

use JsonException;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;

final class JsonResponse extends Response
{
    /**
     * @throws JsonException
     */
    public function __construct(mixed $data, int $status = 200)
    {
        parent::__construct(
            $status,
            new Headers(['Content-Type' => 'application/json']),
            (new StreamFactory())->createStream(json_encode($data, JSON_THROW_ON_ERROR))
        );
    }
}
