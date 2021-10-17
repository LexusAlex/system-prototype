<?php

declare(strict_types=1);

namespace Application\Domain\Authentication\Services\Helpers;

use Application\Domain\Authentication\Entities\User\Types\PasswordHash;
use RuntimeException;
use Webmozart\Assert\Assert;

final class PasswordGenerate
{
    private int $memoryCost;

    public function __construct(int $memoryCost = PASSWORD_ARGON2_DEFAULT_MEMORY_COST)
    {
        $this->memoryCost = $memoryCost;
    }

    public function hash(string $password): string
    {
        Assert::notEmpty($password);
        $hash = password_hash($password, PASSWORD_ARGON2I, ['memory_cost' => $this->memoryCost]);
        if (!$hash) {
            throw new RuntimeException('Unable to generate hash.');
        }
        return $hash;
    }

    public function getPasswordHash(string $password): PasswordHash
    {
        $password = $this->hash($password);

        return new PasswordHash($password);
    }

    public function validate(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }
}
