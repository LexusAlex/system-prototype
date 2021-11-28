<?php

declare(strict_types=1);

namespace Application\Infrastructure\Http\Slim\Response;

use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Twig\Environment;

final class TwigResponse extends Response
{
    private Environment $environment;

    public function __construct(string $template, Environment $environment, $vars = [])
    {
        $this->environment = $environment;
        parent::__construct(
            200,
            new Headers(['Content-Type' => 'text/html']),
            (new StreamFactory())->createStream($environment->render($template, $vars))
        );
    }
}
