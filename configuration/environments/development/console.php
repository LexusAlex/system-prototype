<?php

declare(strict_types=1);

use Application\Infrastructure\Database\Doctrine\Fixtures\Command\FixturesLoadCommand;
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
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    FixturesLoadCommand::class => static function (ContainerInterface $container) {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{fixture_paths:string[]} $config
         */
        $config = $container->get('configuration')['console'];

        return new FixturesLoadCommand(
            $container->get(EntityManagerInterface::class),
            $config['fixture_paths'],
        );
    },

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
                FixturesLoadCommand::class,
            ],
            'fixture_paths' => [
                __DIR__ . '/../../../src/Infrastructure/Database/Doctrine/Fixtures/Authentication',
            ],
        ],
    ],
];
