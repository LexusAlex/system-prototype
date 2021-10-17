<?php

declare(strict_types=1);

namespace Test\Unit\Domain\Authentication\Services\Helpers;

use Application\Domain\Authentication\Services\Helpers\TokenGenerate;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class TokenGenerateTest extends TestCase
{
    public function testSuccess(): void
    {
        $interval = new DateInterval('P7D');
        // P<%Y%M%D><T><%H%M%S>
        $date = new DateTimeImmutable();

        $tokenizer = new TokenGenerate($interval);
        $token = $tokenizer->generate($date);

        self::assertEquals($date->add($interval), $token->getExpires());
    }
}