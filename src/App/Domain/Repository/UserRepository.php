<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyExtension\Domain\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<User>
 *
 * @method User|null findOneById(int $id)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findListBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
    }

    public function remove(User $user): void
    {
        $this->getEntityManager()->remove($user);
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }
}
