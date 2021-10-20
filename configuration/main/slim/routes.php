<?php

declare(strict_types=1);

use Application\Infrastructure\Http\Slim\Actions\HomeAction;
use Application\Infrastructure\Http\Slim\Actions\V1\Authentication\Join\RequestAction;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $application): void {
    $application->get('/', HomeAction::class);

    $application->group('/v1', function (RouteCollectorProxy $group): void {
        $group->group('/authentication', function (RouteCollectorProxy $group): void {
            $group->post('/join', RequestAction::class);
        });
    });
};
