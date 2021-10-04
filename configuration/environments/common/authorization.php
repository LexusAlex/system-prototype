<?php

declare(strict_types=1);

use CasbinAdapter\DBAL\Adapter;
use Psr\Container\ContainerInterface;

return [
    Adapter::class => static function (ContainerInterface $container): Adapter {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{
         *     connection:array<string, mixed>
         * } $settings
         */
        $settings = $container->get('configuration')['doctrine']['connection'];
        return Adapter::newAdapter($settings);
    },
];
