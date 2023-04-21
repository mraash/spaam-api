<?php

declare(strict_types=1);

namespace App\Domain\Service\SpamPanel;

use App\Domain\Entity\SpamPanel;
use App\Domain\Entity\User;
use App\Domain\Repository\SpamPanelRepository;
use App\Domain\Service\SpamPanel\Exception\EmptyTextListException;
use App\Domain\Service\SpamPanel\Exception\SpamPanelNotFoundException;
use App\Domain\Service\VkAccount\VkAccountService;
use App\Http\InputDto\SpamPanel\SpamPanelIdInputDto;
use SymfonyExtension\Domain\Support\NullArg;

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

        $panel->setOwner($owner);
        $panel->setSender($sender);
        $panel->setRecipient($recipient);
        $panel->setTexts($texts);
        $panel->setTimers($timers);

        $this->repository->save($panel);
        $this->repository->flush();

        return $panel;
    }

    /**
     * @param SpamPanelIdInputDto[] $panelDtoList
     *
     * @return SpamPanel[]
     */
    public function updateListFully(User $owner, array $panelDtoList): array
    {
        // TODO: Add something like Http\InputDto, but in Domain layer, and add some mapper
        //   that will map Http Dtos to Domain Dtos. Then replace SpamPanelInputDto to this
        //   new thing in Domain layer.

        /** @var SpamPanel[] */
        $panelList = [];

        foreach ($panelDtoList as $panelDto) {
            // TODO: Select all panelds once in this method
            $panel = $this->findOneById($owner, $panelDto->id);

            /** @var array<array<string,int>> */
            $timers = [];

            foreach ($panelDto->item->timers as $timer) {
                $timers[] = [
                    'seconds' => $timer->seconds,
                    'repeat' => $timer->repeat,
                ];
            }

            $this->updateEntityFully(
                $panel,
                $panelDto->item->senderId,
                $panelDto->item->recipient,
                $panelDto->item->texts,
                $timers,
            );
    
            $this->repository->save($panel);

            $panelList[] = $panel;
        }

        $this->repository->flush();

        return $panelList;
    }

    /**
     * @param string[] $texts
     * @param array<array<string,int>> $timers
     */
    public function updateWhole(
        User $owner,
        int $id,
        int $senderId,
        string $recipient,
        array $texts,
        array $timers
    ): SpamPanel {
        $panel = $this->findOneById($owner, $id);

        $this->updateEntityFully($panel, $senderId, $recipient, $texts, $timers);

        $this->repository->save($panel);
        $this->repository->flush();

        return $panel;
    }

    /**
     * @param string[] $texts
     * @param array<array<string,int>> $timers
     */
    public function updatePart(
        User $owner,
        int $id,
        int|NullArg $senderId,
        string|NullArg $recipient,
        array|NullArg $texts,
        array|NullArg $timers
    ): SpamPanel {
        $panel = $this->findOneById($owner, $id);

        $recipient instanceof NullArg ?: $panel->setRecipient($recipient);
        $texts instanceof NullArg ?: $panel->setTexts($texts);
        $timers instanceof NullArg ?: $panel->setTimers($timers);

        if (!($senderId instanceof NullArg) && $senderId !== $panel->getSender()->getId()) {
            $sender = $this->vkAccountService->findOneById($panel->getOwner(), $senderId);

            $panel->setSender($sender);
        }

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

    public function chooseText(SpamPanel $panel): string
    {
        $textList = $panel->getTexts();
        $count = count($textList);

        if ($count === 0) {
            throw new EmptyTextListException();
        }

        $index = rand(0, count($textList) - 1);

        return $textList[$index];
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

    /**
     * @param string[] $texts
     * @param array<array<string,int>> $timers
     */
    private function updateEntityFully(
        SpamPanel $panel,
        int $senderId,
        string $recipient,
        array $texts,
        array $timers
    ): void {
        $panel->setRecipient($recipient);
        $panel->setTexts($texts);
        $panel->setTimers($timers);

        if ($senderId !== $panel->getSender()->getId()) {
            $sender = $this->vkAccountService->findOneById($panel->getOwner(), $senderId);

            $panel->setSender($sender);
        }
    }
}
