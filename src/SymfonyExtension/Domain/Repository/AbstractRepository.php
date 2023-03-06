<?php

declare(strict_types=1);

namespace SymfonyExtension\Domain\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @template TEntity of object
 * @template-extends ServiceEntityRepository<TEntity>
 *
 * @phpstan-method void save(TEntity $entity)
 * @phpstan-method void remove(TEntity $entity)
 *
 * @phpstan-method TEntity|null findOneById(int $id)
 * @phpstan-method TEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @phpstan-method TEntity[]    findAll()
 * @phpstan-method TEntity[]    findListBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @phpstan-return ?TEntity $entity
     */
    public function findOneById(int $id): ?object
    {
        return parent::find($id);
    }

    /**
     * @param array<string,mixed> $criteria
     * @param array<string,string>|null $orderBy
     *
     * @phpstan-return ?TEntity $entity
     */
    public function findOneBy(array $criteria, array $orderBy = null): ?object
    {
        return parent::findOneBy($criteria, $orderBy);
    }

    /**
     * @phpstan-return TEntity[] $entity
     */
    public function findAll(): array
    {
        return parent::findAll();
    }

    /**
     * @param array<string,mixed> $criteria
     * @param array<string,string>|null $orderBy
     *
     * @phpstan-return TEntity[] $entity
     */
    public function findListBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @deprecated
     */
    public function find(mixed $id, mixed $lockMode = null, mixed $lockVersion = null): ?object
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    /**
     * @deprecated
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }
}
