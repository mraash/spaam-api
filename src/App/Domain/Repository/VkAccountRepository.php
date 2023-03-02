<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Entity\VkAccount;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyExtension\Domain\Repository\AbstractRepository;

/**
 * @extends AbstractRepository<VkAccount>
 *
 * @method void save(VkAccount $entity)
 * @method void remove(VkAccount $entity)
 *
 * @method VkAccount|null find(int $id, ?int $lockMode, ?int $lockVersion)
 * @method VkAccount|null findOneBy(array $criteria, ?array $orderBy)
 * @method VkAccount[]    findAll()
 * @method VkAccount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VkAccountRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VkAccount::class);
    }

    public function findByVkId(User $owner, int $vkId): ?VkAccount
    {
        return $this->findOneBy([
            'owner' => $owner,
            'vkId' => $vkId,
        ]);
    }
}
