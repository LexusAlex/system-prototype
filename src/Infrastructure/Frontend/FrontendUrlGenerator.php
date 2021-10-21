<?php

declare(strict_types=1);

namespace Application\Infrastructure\Frontend;

final class FrontendUrlGenerator
{
    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @param array<string> $params
     */
    public function generate(string $uri, array $params = []): string
    {
        return $this->baseUrl
            . ($uri ? '/' . $uri : '')
            . ($params ? '?' . http_build_query($params) : '');
    }
}
