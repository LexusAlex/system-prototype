<?php

declare(strict_types=1);

namespace Application\Application\UseCases\Authentication\Command\JoinByEmail\Request;

use Application\Domain\Authentication\Entities\User\Types\Email;
use Application\Domain\Authentication\Entities\User\Types\Id;
use Application\Domain\Authentication\Entities\User\User;
use Application\Domain\Authentication\Services\Helpers\PasswordGenerate;
use Application\Domain\Authentication\Services\Helpers\TokenGenerate;
use Application\Infrastructure\Database\Doctrine\Helpers\Save;
use Application\Infrastructure\Database\Doctrine\Repositories\Authentication\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use DomainException;

final class Handler
{
    private PasswordGenerate $passwordGenerate;
    private TokenGenerate $tokenGenerate;
    private UserRepository $userRepository;
    private Save $save;

    public function __construct(
        PasswordGenerate $passwordGenerate,
        TokenGenerate $tokenGenerate,
        UserRepository $userRepository,
        Save $save
    ) {
        $this->passwordGenerate = $passwordGenerate;
        $this->tokenGenerate = $tokenGenerate;
        $this->userRepository = $userRepository;
        $this->save = $save;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function handle(Command $command): void
    {
        $dateCreated = new DateTimeImmutable();

        $email = new Email($command->email);

        if ($this->userRepository->hasByEmail($email)) {
            throw new DomainException('User already exists.');
        }

        $user = User::joinByEmailRequest(
            Id::generate(),
            $dateCreated,
            $email,
            $this->passwordGenerate->getPasswordHash($command->password),
            $this->tokenGenerate->generate($dateCreated)
        );

        $this->userRepository->add($user);

        $this->save->save();
    }
}
