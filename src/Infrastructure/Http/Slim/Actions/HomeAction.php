<?php

declare(strict_types=1);

namespace Application\Infrastructure\Http\Slim\Actions;

use Application\Infrastructure\Http\Slim\Response\TwigResponse;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Twig\Environment;

final class HomeAction implements RequestHandlerInterface
{
    private Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @throws JsonException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new TwigResponse('template1/pages/home.html.twig', $this->environment);
    }
}
