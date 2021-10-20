<?php

declare(strict_types=1);

namespace Test\Functional\V1\Authentication\Join;

use Application\Domain\Authentication\Entities\User\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Factory\ServerRequestFactory;

/**
 * @internal
 */
final class RequestActionTest extends TestCase
{
    /**
     * @throws \JsonException
     * @throws ORMException
     */
    public function testSuccessRequest(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../../../configuration/main/container.php';

        $application = (require __DIR__ . '/../../../../../configuration/main/slim/application.php')($container);

        $request = (new ServerRequestFactory())
            ->createServerRequest("POST", '/v1/authentication/join')
            ->withHeader('Accept', 'application/json')
            ->withHeader('Content-Type', 'application/json');
        $request->getBody()->write(json_encode(['email' => 'test@app.test', 'password' => 'new-password'], JSON_THROW_ON_ERROR));

        $application->handle($request);

        /** @var EntityManager $em */
        $em = $container->get(EntityManagerInterface::class);
        $repository = $em->getRepository(User::class);
        /** @var User $user */
        $user = $repository->findOneBy(['email' => 'test@app.test']);

        self::assertNotNull($user);

        $em->remove($user);
        $em->flush();

        $user = $repository->findOneBy(['email' => 'test@app.test']);
        self::assertNull($user);

    }

}