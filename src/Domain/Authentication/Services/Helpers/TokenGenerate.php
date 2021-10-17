<?php

declare(strict_types=1);

namespace Application\Domain\Authentication\Services\Helpers;

use Application\Domain\Authentication\Entityes\User\Types\Token;
use DateInterval;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

final class TokenGenerate
{
    private DateInterval $interval;

    public function __construct(DateInterval $interval)
    {
        $this->interval = $interval;
    }

    public function generate(DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date->add($this->interval)
        );
    }
}
