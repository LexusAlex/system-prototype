<?php

declare(strict_types=1);

use Slim\App;

return static function (App $application): void {
    $application->addErrorMiddleware(true, true, true);
};
