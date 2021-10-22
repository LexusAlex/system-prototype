<?php

declare(strict_types=1);

namespace Application\Infrastructure\Http\Slim\Actions\V1\Authentication\Join;

use Application\Application\UseCases\Authentication\Command\JoinByEmail\Request\Command;
use Application\Application\UseCases\Authentication\Command\JoinByEmail\Request\Handler;
use Application\Domain\Authentication\Entities\User\Types\Email;
use Application\Infrastructure\Http\Slim\Response\EmptyResponse;
use Application\Infrastructure\Validator\Validator;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RequestAction implements RequestHandlerInterface
{
    private Handler $handler;
    private Validator $validator;

    public function __construct(Handler $handler, Validator $validator)
    {
        $this->handler = $handler;
        $this->validator = $validator;
    }

    /**
     * @throws JsonException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /**
         * @var array{email:?string, password:?string} $data
         */
        $data = $request->getParsedBody();

        // Команда VO
        $command = new Command();
        $command->email = $data['email'] ?? '';
        $command->password = $data['password'] ?? '';

        $this->validator->validate($command);

        $this->handler->handle($command);

        return new EmptyResponse(201);
    }
}
