<?php

declare(strict_types=1);

namespace App\Domain\Service\VkAccount;

use App\Domain\Entity\User;
use App\Domain\Entity\VkAccount;
use App\Domain\Repository\VkAccountRepository;
use App\Domain\Service\Vk\VkService;
use App\Domain\Service\VkAccount\Exception\VkAccountAlreadyAddedException;
use App\Domain\Service\VkAccount\Exception\VkAccountNotFoundException;

class VkAccountService
{
    public function __construct(
        private VkAccountRepository $repository,
        private VkService $vkService,
    ) {
    }

    public function getCreationLink(): string
    {
        return $this->vkService->getCreationLink();
    }

    public function create(User $owner, int $vkId, string $vkAccessToken): VkAccount
    {
        if ($this->repository->findOneByVkIdWithOwner($owner, $vkId) !== null) {
            throw new VkAccountAlreadyAddedException();
        }

        $userInfo = $this->vkService->getUser($vkAccessToken, $vkId);

        $vkAccount = new VkAccount();

        $vkAccount
            ->setOwner($owner)
            ->setVkAccessToken($vkAccessToken)
            ->setVkId($vkId)
            ->setVkSlug($userInfo->domain)
            ->setVkFullName("$userInfo->firstName $userInfo->lastName")
        ;

        $this->repository->save($vkAccount);
        $this->repository->flush();

        return $vkAccount;
    }

    public function delete(User $owner, int $id): void
    {
        $vkAccount = $this->repository->findOneBy([
            'id' => $id,
            'owner' => $owner,
        ]);

        if ($vkAccount === null) {
            throw new VkAccountNotFoundException();
        }

        $this->repository->remove($vkAccount);
        $this->repository->flush();
    }

    /**
     * @return VkAccount[]
     */
    public function findAll(User $owner): array
    {
        return $this->repository->findAllWithOwner($owner);
    }

    public function findOneById(User $owner, int $id): VkAccount
    {
        $vkAccount = $this->repository->findOneByIdWithOwner($owner, $id);

        if ($vkAccount === null) {
            throw new VkAccountNotFoundException();
        }

        return $vkAccount;
    }
}
