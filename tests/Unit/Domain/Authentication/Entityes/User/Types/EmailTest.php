<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Authentication\Entityes\User\Types;


use Application\Domain\Authentication\Entityes\User\Types\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class EmailTest extends TestCase
{
    public function testSuccess(): void
    {
        $email = new Email($value = 'email@application.test');
        self::assertEquals($value, $email->getValue());
    }

    public function testUpperCase(): void
    {
        $email = new Email(strtoupper('test@mysuper-email-test.dev'));

        self::assertEquals('test@mysuper-email-test.dev', $email->getValue());
    }

    public function testIncorrect(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('not-email');
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('');
    }
}