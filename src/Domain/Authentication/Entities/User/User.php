<?php

declare(strict_types=1);

namespace Application\Domain\Authentication\Entities\User;

use Application\Domain\Authentication\Entities\User\Types\Email;
use Application\Domain\Authentication\Entities\User\Types\Id;
use Application\Domain\Authentication\Entities\User\Types\PasswordHash;
use Application\Domain\Authentication\Entities\User\Types\Token;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="authentication_users")
 */
final class User
{
    /**
     * @ORM\Column(type="authentication_user_id")
     * @ORM\Id
     */
    private Id $id;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $dateCreated;
    /**
     * @ORM\Column(type="authentication_user_email", unique=true)
     */
    private Email $email;
    /**
     * @ORM\Embedded(class="Application\Domain\Authentication\Entities\User\Types\Token")
     */
    private ?Token $joinConfirmToken = null;
    /**
     * @ORM\Column(type="authentication_user_password_hash")
     */
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

    /**
     * @ORM\PostLoad
     */
    public function checkEmbeds(): void
    {
        if ($this->joinConfirmToken && $this->joinConfirmToken->isEmpty()) {
            $this->joinConfirmToken = null;
        }
    }
}
