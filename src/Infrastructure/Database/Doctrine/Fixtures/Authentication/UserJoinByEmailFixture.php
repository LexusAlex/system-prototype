<?php

declare(strict_types=1);

namespace Application\Infrastructure\Database\Doctrine\Fixtures\Authentication;

use Application\Domain\Authentication\Entities\User\Types\Email;
use Application\Domain\Authentication\Entities\User\Types\Id;
use Application\Domain\Authentication\Entities\User\Types\PasswordHash;
use Application\Domain\Authentication\Entities\User\Types\Token;
use Application\Domain\Authentication\Entities\User\User;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

final class UserJoinByEmailFixture extends AbstractFixture
{
    // 'password'
    private const PASSWORD_HASH = '$2y$12$qwnND33o8DGWvFoepotSju7eTAQ6gzLD/zy6W8NCVtiHPbkybz.w6';

    public function load(ObjectManager $manager): void
    {
        $user = User::joinByEmailRequest(
            new Id('00000000-0000-0000-0000-000000000001'),
            $date = new DateTimeImmutable('-30 days'),
            new Email('my-email.test.ua-dev@app.test-dev.up'),
            new PasswordHash(self::PASSWORD_HASH),
            new Token($value = Uuid::uuid4()->toString(), $date->modify('+1 day'))
        );

        $user2 = User::joinByEmailRequest(
            new Id('00000000-0000-0000-0000-000000000002'),
            $date = new DateTimeImmutable(),
            new Email('my-email.test.ua-dev2@app.test-dev.up'),
            new PasswordHash(self::PASSWORD_HASH),
            new Token($value = Uuid::uuid4()->toString(), $date->modify('+4 day'))
        );

        $manager->persist($user);
        $manager->persist($user2);

        $manager->flush();
    }
}
