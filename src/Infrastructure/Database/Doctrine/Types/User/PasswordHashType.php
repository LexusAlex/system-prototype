<?php

declare(strict_types=1);

namespace Application\Infrastructure\Database\Doctrine\Types\User;

use Application\Domain\Authentication\Entities\User\Types\PasswordHash;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class PasswordHashType extends StringType
{
    public const NAME = 'authentication_user_password_hash';

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        return $value instanceof PasswordHash ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?PasswordHash
    {
        return !empty($value) ? new PasswordHash((string)$value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
