<?php

declare(strict_types=1);

namespace Application\Infrastructure\Http\Slim\Response;

use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Response;

final class EmptyResponse extends Response
{
    public function __construct(int $status = 204)
    {
        /** @var resource $resource */
        $resource = fopen('php://temp', 'rb');

        parent::__construct(
            $status,
            null,
            (new StreamFactory())->createStreamFromResource($resource)
        );
    }
}
