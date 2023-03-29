<?php

declare(strict_types=1);

namespace App\Domain\Service\VkAccount;

use App\Domain\Entity\User;
use App\Domain\Entity\VkAccount;
use App\Domain\Repository\VkAccountRepository;
use App\Domain\Service\Vk\VkService;
use App\Domain\Service\VkAccount\Exception\VkAccountAlreadyAddedException;
use App\Domain\Service\VkAccount\Exception\VkAccountNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class VkAccountService
{
    public function __construct(
        private VkService $vkService,
        private VkAccountRepository $repository,
        private UrlGeneratorInterface $urlGenerator,
        private bool $isDev,
        private int $vkAppId,
    ) {
    }

    public function getCreationLink(): string
    {
        $redirectUrl = $this->urlGenerator->generate(
            'api.v1.vkAccounts.create',
            [],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        if ($this->isDev) {
            $redirectUrl = null;
        }

        return $this->vkService->getAuthLink($this->vkAppId, $redirectUrl);
    }

    public function create(User $owner, int $vkId, string $vkAccessToken): VkAccount
    {
        if ($this->repository->findOneByVkIdWithOwner($owner, $vkId) !== null) {
            throw new VkAccountAlreadyAddedException();
        }

        $vkAccount = new VkAccount();

        $vkAccount
            ->setOwner($owner)
            ->setVkId($vkId)
            ->setVkAccessToken($vkAccessToken)
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
