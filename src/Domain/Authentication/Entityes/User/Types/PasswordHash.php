<?php

declare(strict_types=1);

namespace Application\Domain\Authentication\Entityes\User\Types;

use Webmozart\Assert\Assert;

final class PasswordHash
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
