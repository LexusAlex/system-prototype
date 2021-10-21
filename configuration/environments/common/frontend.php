<?php

declare(strict_types=1);

use Application\Infrastructure\Frontend\FrontendUrlGenerator;
use Psr\Container\ContainerInterface;

return [
    FrontendUrlGenerator::class => static function (ContainerInterface $container): FrontendUrlGenerator {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{url:string} $config
         */
        $config = $container->get('configuration')['frontend'];

        return new FrontendUrlGenerator($config['url']);
    },

    'configuration' => [
        'frontend' => [
            'url' => getenv('FRONTEND_URL'),
        ],
    ],
];
