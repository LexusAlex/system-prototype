<?php

declare(strict_types=1);

use Slim\App;

return static function (App $application): void {
    $application->addErrorMiddleware((bool)getenv('APPLICATION_DEBUG'), getenv('APPLICATION_ENVIRONMENT') !== 'test', true);
};
