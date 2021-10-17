<?php

declare(strict_types=1);

namespace Test\Unit\Application\Authentication\Command;

use Application\Domain\Authentication\Entityes\User\Types\Email;
use Application\Domain\Authentication\Entityes\User\Types\Id;
use Application\Domain\Authentication\Entityes\User\Types\PasswordHash;
use Application\Domain\Authentication\Entityes\User\Types\Token;
use Application\Domain\Authentication\Entityes\User\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 */
final class JoinByEmailRequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = User::joinByEmailRequest(
            $id = Id::generate(),
            $dateCreated = new DateTimeImmutable(),
            $email = new Email('mail-test.test@example.ua.com'),
            $passwordHash = new PasswordHash('mega-password'),
            $token = new Token(Uuid::uuid4()->toString(), new DateTimeImmutable())
        );

        self::assertEquals($id, $user->getId());
        self::assertEquals($dateCreated, $user->getDateCreated());
        self::assertEquals($email, $user->getEmail());
        self::assertEquals($passwordHash, $user->getPasswordHash());
        self::assertEquals($token, $user->getJoinConfirmToken());
    }
}