<?php

declare(strict_types=1);

namespace Application\Domain\Authentication\Entityes\User;

use Application\Domain\Authentication\Entityes\User\Types\Email;
use Application\Domain\Authentication\Entityes\User\Types\Id;
use Application\Domain\Authentication\Entityes\User\Types\PasswordHash;
use Application\Domain\Authentication\Entityes\User\Types\Token;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

final class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private Id $id;
    private DateTimeImmutable $dateCreated;
    private Email $email;
    private ?Token $joinConfirmToken = null;
    private ?PasswordHash $passwordHash = null;

    private function __construct(Id $id, DateTimeImmutable $dateCreated, Email $email)
    {
        $this->id = $id;
        $this->dateCreated = $dateCreated;
        $this->email = $email;
    }

    public static function joinByEmailRequest(
        Id $id,
        DateTimeImmutable $dateCreated,
        Email $email,
        PasswordHash $passwordHash,
        Token $token
    ): self {
        $user = new self($id, $dateCreated, $email);
        $user->joinConfirmToken = $token;
        $user->passwordHash = $passwordHash;
        return $user;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDateCreated(): DateTimeImmutable
    {
        return $this->dateCreated;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getJoinConfirmToken(): ?Token
    {
        return $this->joinConfirmToken;
    }

    public function getPasswordHash(): ?PasswordHash
    {
        return $this->passwordHash;
    }
}
