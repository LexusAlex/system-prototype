<?php

declare(strict_types=1);

use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;

return [
    'configuration' => [
        'console' => [
            'commands' => [
                MigrateCommand::class,
            ],
        ],
    ],
];
