<?php

declare(strict_types=1);

namespace App\Domain\Service\SpamPanel;

use App\Domain\Entity\SpamPanel;
use App\Domain\Entity\User;
use App\Domain\Entity\VkAccount;
use App\Domain\Repository\SpamPanelRepository;
use App\Domain\Service\SpamPanel\Exception\SpamPanelNotFoundException;
use App\Domain\Service\VkAccount\VkAccountService;

class SpamPanelService
{
    public function __construct(
        private SpamPanelRepository $repository,
        private VkAccountService $vkAccountService,
    ) {
    }

    /**
     * @param string[] $texts
     * @param array<array<string,int>> $timers
     */
    public function create(User $owner, int $senderId, string $recipient, array $texts, array $timers): SpamPanel
    {
        $sender = $this->vkAccountService->findOneById($owner, $senderId);

        $panel = new SpamPanel();

        $panel
            ->setOwner($owner)
            ->setSender($sender)
            ->setRecipient($recipient)
            ->setTexts($texts)
            ->setTimers($timers)
        ;

        $this->repository->save($panel);
        $this->repository->flush();

        return $panel;
    }

    public function delete(User $owner, int $id): void
    {
        $panel = $this->repository->findOneByIdWithOwner($owner, $id);

        if ($panel === null) {
            throw new SpamPanelNotFoundException();
        }

        $this->repository->remove($panel);
        $this->repository->flush();
    }

    /**
     * @return SpamPanel[]
     */
    public function findAll(User $owner): array
    {
        return $this->repository->findAllWithOwner($owner);
    }

    public function findOneById(User $owner, int $id): SpamPanel
    {
        $panel = $this->repository->findOneByIdWithOwner($owner, $id);

        if ($panel === null) {
            throw new SpamPanelNotFoundException();
        }

        return $panel;
    }
}
