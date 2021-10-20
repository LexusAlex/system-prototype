<?php

declare(strict_types=1);

use Application\Infrastructure\Http\Slim\Middleware\ClearEmptyInput;
use Application\Infrastructure\Http\Slim\Middleware\DomainExceptionHandler;
use Application\Infrastructure\Http\Slim\Middleware\TranslatorLocale;
use Application\Infrastructure\Http\Slim\Middleware\ValidationExceptionHandler;
use Middlewares\ContentLanguage;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return static function (App $application): void {
    $application->add(DomainExceptionHandler::class);
    $application->add(ValidationExceptionHandler::class);
    $application->add(ClearEmptyInput::class);
    $application->add(TranslatorLocale::class);
    $application->add(ContentLanguage::class);
    $application->addBodyParsingMiddleware();
    $application->add(ErrorMiddleware::class);
    //$application->addErrorMiddleware((bool)getenv('APPLICATION_DEBUG'), getenv('APPLICATION_ENVIRONMENT') !== 'test', true);
    // Указывать снизу вверх от action
};
