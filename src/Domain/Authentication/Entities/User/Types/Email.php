<?php

declare(strict_types=1);

namespace Application\Domain\Authentication\Entities\User\Types;

use Webmozart\Assert\Assert;

final class Email
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        Assert::email($value);
        $this->value = mb_strtolower($value);
    }

    public function __toString(): string
    {
        return $this->getValue();
    }

    public function isEqualTo(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
