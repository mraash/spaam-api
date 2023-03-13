<?php

namespace App\Domain\Repository;

use App\Domain\Entity\SpamPanel;
use App\Domain\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyExtension\Domain\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<SpamPanel>
 *
 * @method SpamPanel|null findOneById(int $id)
 * @method SpamPanel|null findOneBy(array $criteria, array $orderBy = null)
 * @method SpamPanel[] findAll()
 * @method SpamPanel[] findListBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null)
 */
class SpamPanelRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SpamPanel::class);
    }

    public function save(SpamPanel $spamPanel): void
    {
        $this->getEntityManager()->persist($spamPanel);
    }

    public function remove(SpamPanel $spamPanel): void
    {
        $this->getEntityManager()->remove($spamPanel);
    }

    /**
     * @return SpamPanel[]
     */
    public function findAllWithOwner(User $user): array
    {
        return $this->findListBy([
            'owner' => $user,
        ]);
    }

    public function findOneByIdWithOwner(User $user, int $id): ?SpamPanel
    {
        return $this->findOneBy([
            'owner' => $user,
            'id' => $id,
        ]);
    }
}
