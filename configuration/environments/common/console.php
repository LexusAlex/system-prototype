<?php

declare(strict_types=1);

use Doctrine\Migrations\Tools\Console\Command\CurrentCommand;
use Doctrine\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\Migrations\Tools\Console\Command\DumpSchemaCommand;
use Doctrine\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\Migrations\Tools\Console\Command\LatestCommand;
use Doctrine\Migrations\Tools\Console\Command\ListCommand;
use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\Migrations\Tools\Console\Command\RollupCommand;
use Doctrine\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\Migrations\Tools\Console\Command\SyncMetadataCommand;
use Doctrine\Migrations\Tools\Console\Command\UpToDateCommand;
use Doctrine\Migrations\Tools\Console\Command\VersionCommand;

return [
    'configuration' => [
        'console' => [
            'commands' => [
                CurrentCommand::class,
                DiffCommand::class,
                DumpSchemaCommand::class,
                ExecuteCommand::class,
                GenerateCommand::class,
                LatestCommand::class,
                ListCommand::class,
                MigrateCommand::class,
                RollupCommand::class,
                StatusCommand::class,
                SyncMetadataCommand::class,
                UpToDateCommand::class,
                VersionCommand::class,
            ],
        ],
    ],
];
