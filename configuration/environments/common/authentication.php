<?php

declare(strict_types=1);

use Application\Domain\Authentication\Entities\User\User;
use Application\Domain\Authentication\Services\Helpers\TokenGenerate;
use Application\Infrastructure\Database\Doctrine\Repositories\Authentication\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    UserRepository::class => static function (ContainerInterface $container): UserRepository {
        $em = $container->get(EntityManagerInterface::class);
        $repo = $em->getRepository(User::class);
        return new UserRepository($em, $repo);
    },

    TokenGenerate::class => static function (ContainerInterface $container): TokenGenerate {
        /**
         * @psalm-suppress MixedArrayAccess
         * @var array{token_ttl:string} $config
         */
        $config = $container->get('configuration')['auth'];

        return new TokenGenerate(new DateInterval($config['token_ttl']));
    },

    'configuration' => [
        'auth' => [
            'token_ttl' => 'PT4H',
        ],
    ],
];
