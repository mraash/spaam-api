<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Entity\VkAccount;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyExtension\Domain\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<VkAccount>
 *
 * @method VkAccount|null findOneById(int $id)
 * @method VkAccount|null findOneBy(array $criteria, array $orderBy = null)
 * @method VkAccount[] findAll()
 * @method VkAccount[] findListBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null)
 */
class VkAccountRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VkAccount::class);
    }

    public function save(VkAccount $vkAccount): void
    {
        $this->getEntityManager()->persist($vkAccount);
    }

    public function remove(VkAccount $vkAccount): void
    {
        $this->getEntityManager()->remove($vkAccount);
    }

    /**
     * @return VkAccount[]
     */
    public function findAllWithOwner(User $owner): array
    {
        return $this->findListBy([
            'owner' => $owner,
        ]);
    }

    public function findOneByIdWithOwner(User $owner, int $id): ?VkAccount
    {
        return $this->findOneBy([
            'owner' => $owner,
            'id' => $id,
        ]);
    }

    public function findOneByVkIdWithOwner(User $owner, int $vkId): ?VkAccount
    {
        return $this->findOneBy([
            'owner' => $owner,
            'vkId' => $vkId,
        ]);
    }
}
