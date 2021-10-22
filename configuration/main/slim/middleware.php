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
    // Вызов Action
    $application->add(DomainExceptionHandler::class); // Доменные исключения
    $application->add(ValidationExceptionHandler::class); // Валидация полей, для которых указаны правила валидации
    $application->add(ClearEmptyInput::class); // Автоматический трим всех входящих полей
    $application->add(TranslatorLocale::class); // Автоматический переключатель языков
    $application->add(ContentLanguage::class); // Парсинг заголовка Accept-Language
    $application->addBodyParsingMiddleware(); // Парсинг входящих параметров в массив
    $application->add(ErrorMiddleware::class); // Обработчик ошибок
    // Application index.php
};
