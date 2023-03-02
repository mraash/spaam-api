<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyExtension\Domain\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<User>
 *
 * @method void save(User $entity)
 * @method void remove(User $entity)
 *
 * @method User|null find(int $id, ?int $lockMode, ?int $lockVersion)
 * @method User|null findOneBy(array $criteria, ?array $orderBy)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->findOneBy(['email' => $email]);
    }
}
