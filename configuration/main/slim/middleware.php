<?php

declare(strict_types=1);

use Application\Infrastructure\Http\Slim\Middleware\ValidationExceptionHandler;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $application): void {
    $application->add(ValidationExceptionHandler::class);
    $application->addBodyParsingMiddleware();
    $application->add(ErrorMiddleware::class);
    //$application->addErrorMiddleware((bool)getenv('APPLICATION_DEBUG'), getenv('APPLICATION_ENVIRONMENT') !== 'test', true);
};
