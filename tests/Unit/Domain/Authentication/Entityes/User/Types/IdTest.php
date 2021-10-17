<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Authentication\Entityes\User\Types;

use Application\Domain\Authentication\Entities\User\Types\Id;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

/**
 * @internal
 */
final class IdTest extends TestCase
{
    public function testSuccess(): void
    {
        $id = new Id($value = Uuid::uuid4()->toString());
        self::assertEquals($value, $id->getValue());
    }

    public function testUpperCase(): void
    {
        $value = Uuid::uuid4()->toString();
        $id = new Id(mb_strtoupper($value));
        self::assertEquals($value, $id->getValue());
    }

    public function testGenerate(): void
    {
        $id = Id::generate();
        self::assertNotEmpty($id->getValue());
    }

    public function testIncorrect(): void
    {
        // проверяем что будет брошено исключение
        $this->expectException(InvalidArgumentException::class);
        new Id('not-valid-uuid-12345');
    }

    public function testEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Id('');
    }
}

