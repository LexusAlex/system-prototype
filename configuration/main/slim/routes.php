<?php

declare(strict_types=1);

use Application\Infrastructure\Http\Slim\Actions\HomeAction;
use Slim\App;

return static function (App $application): void {
    $application->get('/', HomeAction::class);
};
