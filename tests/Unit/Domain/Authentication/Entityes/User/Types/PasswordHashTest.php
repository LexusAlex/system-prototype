<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Authentication\Entityes\User\Types;

use Application\Domain\Authentication\Entities\User\Types\PasswordHash;
use Application\Domain\Authentication\Entities\User\Types\Token;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers Token
 */
class PasswordHashTest extends TestCase
{
    public function testSuccess(): void
    {
        $password = new PasswordHash($value = 'password');

        self::assertEquals($value, $password->getValue());
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new PasswordHash('');
    }
}