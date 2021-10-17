<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Authentication\Services\Helpers;


use Application\Domain\Authentication\Services\Helpers\PasswordGenerate;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class PasswordGenerateTest extends TestCase
{
    public function testHash(): void
    {
        $hash = new PasswordGenerate(16);

        $hash = $hash->hash($password = 'new-password');

        self::assertNotEmpty($hash);
        self::assertNotEquals($password, $hash);
    }

    public function testHashEmpty(): void
    {
        $hash = new PasswordGenerate(16);

        $this->expectException(InvalidArgumentException::class);
        $hash->hash('');
    }

    public function testValidate(): void
    {
        $generate = new PasswordGenerate(16);

        $hash = $generate->hash($password = 'new-password');

        self::assertTrue($generate->validate($password, $hash));
        self::assertFalse($generate->validate('wrong-password', $hash));
    }
}