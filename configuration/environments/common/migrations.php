<?php

declare(strict_types=1);

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\Migrations\Tools\Console\Command;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    DependencyFactory::class => static function (ContainerInterface $container) {
        $entityManager = $container->get(EntityManagerInterface::class);

        $configuration = new Doctrine\Migrations\Configuration\Configuration();
        $configuration->addMigrationsDirectory('Migrations', __DIR__ . '/../../../migrations');
        $configuration->setAllOrNothing(true);
        $configuration->setCheckDatabasePlatform(false);

        $storageConfiguration = new TableMetadataStorageConfiguration();
        $storageConfiguration->setTableName('migrations');

        $configuration->setMetadataStorageConfiguration($storageConfiguration);

        return DependencyFactory::fromEntityManager(
            new ExistingConfiguration($configuration),
            new ExistingEntityManager($entityManager)
        );
    },
    Command\CurrentCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\CurrentCommand($factory);
    },
    Command\DiffCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\DiffCommand($factory);
    },
    Command\DumpSchemaCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\DumpSchemaCommand($factory);
    },
    Command\ExecuteCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\ExecuteCommand($factory);
    },
    Command\GenerateCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\GenerateCommand($factory);
    },
    Command\LatestCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\LatestCommand($factory);
    },
    Command\ListCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\ListCommand($factory);
    },
    Command\MigrateCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\MigrateCommand($factory);
    },
    Command\RollupCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\RollupCommand($factory);
    },
    Command\StatusCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\StatusCommand($factory);
    },
    Command\SyncMetadataCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\SyncMetadataCommand($factory);
    },
    Command\UpToDateCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\UpToDateCommand($factory);
    },
    Command\VersionCommand::class => static function (ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\VersionCommand($factory);
    },
];
