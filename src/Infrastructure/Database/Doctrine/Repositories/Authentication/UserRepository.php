<?php

declare(strict_types=1);

namespace Application\Infrastructure\Database\Doctrine\Repositories\Authentication;

use Application\Domain\Authentication\Entities\User\Types\Email;
use Application\Domain\Authentication\Entities\User\Types\Id;
use Application\Domain\Authentication\Entities\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use DomainException;

final class UserRepository
{
    /**
     * @var EntityRepository<User>
     */
    private EntityRepository $repo;
    private EntityManagerInterface $em;

    /**
     * @param EntityRepository<User> $repo
     */
    public function __construct(EntityManagerInterface $em, EntityRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function hasByEmail(Email $email): bool
    {
        return $this->repo->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->andWhere('t.email = :email')
            ->setParameter(':email', $email->getValue())
            ->getQuery()->getSingleScalarResult() > 0;
    }

    public function get(Id $id): User
    {
        $user = $this->repo->find($id->getValue());
        if ($user === null) {
            throw new DomainException('User is not found.');
        }
        return $user;
    }

    public function getByEmail(Email $email): User
    {
        $user = $this->repo->findOneBy(['email' => $email->getValue()]);
        if ($user === null) {
            throw new DomainException('User is not found.');
        }
        return $user;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }

    public function remove(User $user): void
    {
        $this->em->remove($user);
    }
}
