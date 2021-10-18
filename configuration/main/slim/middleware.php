<?php

declare(strict_types=1);

use Application\Infrastructure\Http\Slim\Middleware\ValidationExceptionHandler;
use Slim\App;

return static function (App $application): void {
    $application->add(ValidationExceptionHandler::class);
    $application->addBodyParsingMiddleware();
    $application->addErrorMiddleware((bool)getenv('APPLICATION_DEBUG'), getenv('APPLICATION_ENVIRONMENT') !== 'test', true);
};
