<?php

declare(strict_types=1);

namespace App\Domain\Service\SpamPanel;

use App\Domain\Entity\SpamPanel;
use App\Domain\Entity\User;
use App\Domain\Entity\VkAccount;
use App\Domain\Repository\SpamPanelRepository;
use App\Domain\Service\SpamPanel\Exception\EmptyTextListException;
use App\Domain\Service\SpamPanel\Exception\SpamPanelNotFoundException;
use App\Domain\Service\VkAccount\VkAccountService;
use App\Http\Request\InputDto\SpamPanel\SpamPanelIdInputDto;
use App\Http\Request\InputDto\SpamPanel\SpamPanelInputDto;
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
     * @param array<array<string,int|null>> $timers
     */
    public function create(User $owner, ?int $senderId, string $recipient, array $texts, array $timers): SpamPanel
    {
        $sender = $this->getSenderOrNull($owner, $senderId);

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
     * @param SpamPanelInputDto[] $panelDtoList
     *
     * @return SpamPanel[]
     */
    public function createList(User $owner, array $panelDtoList): array
    {
        $panelList = [];

        foreach ($panelDtoList as $panelDto) {
            $timers = [];

            foreach ($panelDto->timers as $timerObject) {
                $timers[] = [
                    'seconds' => $timerObject->seconds,
                    'repeat' => $timerObject->repeat,
                ];
            }

            // todo: Optimize vk accounts selection here
            $sender = $this->getSenderOrNull($owner, $panelDto->senderId);

            $panel = new SpamPanel();

            $panel->setOwner($owner);
            $panel->setSender($sender);
            $panel->setRecipient($panelDto->recipient);
            $panel->setTexts($panelDto->texts);
            $panel->setTimers($timers);

            $this->repository->save($panel);

            $panelList[] = $panel;
        }

        $this->repository->flush();

        return $panelList;
    }

    /**
     * @param SpamPanelIdInputDto[] $panelDtoList
     *
     * @return SpamPanel[]
     */
    public function updateListFully(User $owner, array $panelDtoList): array
    {
        // todo: Add something like Http\InputDto, but in Domain layer, and add some mapper
        //   that will map Http Dtos to Domain Dtos. Then replace SpamPanelInputDto to this
        //   new thing in Domain layer.

        /** @var SpamPanel[] */
        $panelList = [];

        foreach ($panelDtoList as $panelDto) {
            // todo: Select all panelds once in this method
            $panel = $this->findOneById($owner, $panelDto->id);

            /** @var array<array<string,int|null>> */
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
     * @param array<array<string,int|null>> $timers
     */
    public function updateWhole(
        User $owner,
        int $id,
        ?int $senderId,
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
     * @param array<array<string,int|null>> $timers
     */
    public function updatePart(
        User $owner,
        int $id,
        int|null|NullArg $senderId,
        string|NullArg $recipient,
        array|NullArg $texts,
        array|NullArg $timers
    ): SpamPanel {
        $panel = $this->findOneById($owner, $id);

        $recipient instanceof NullArg ?: $panel->setRecipient($recipient);
        $texts instanceof NullArg ?: $panel->setTexts($texts);
        $timers instanceof NullArg ?: $panel->setTimers($timers);

        if (!($senderId instanceof NullArg) && $senderId !== $panel->getSender()?->getId()) {
            $sender = $this->getSenderOrNull($owner, $senderId);

            $panel->setSender($sender);
        }

        $this->repository->save($panel);
        $this->repository->flush();

        return $panel;
    }

    /**
     * @param int[] $idList
     */
    public function deleteList(User $owner, array $idList): void
    {
        $panelList = $this->repository->findListBy([
            'owner' => $owner,
            'id' => $idList,
        ]);

        if (count($panelList) < count($idList)) {
            $findedIdList = array_map(fn (SpamPanel $item) => $item->getId(), $panelList);

            foreach ($idList as $id) {
                if (!in_array($id, $findedIdList)) {
                    throw SpamPanelNotFoundException::fromIdMessage($id);
                }
            }
        }

        $this->repository->removeList($panelList);
        $this->repository->flush();
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
     * @param array<array<string,int|null>> $timers
     */
    private function updateEntityFully(
        SpamPanel $panel,
        ?int $senderId,
        string $recipient,
        array $texts,
        array $timers
    ): void {
        $panel->setRecipient($recipient);
        $panel->setTexts($texts);
        $panel->setTimers($timers);

        if ($senderId !== $panel->getSender()?->getId()) {
            $sender = $this->getSenderOrNull($panel->getOwner(), $senderId);

            $panel->setSender($sender);
        }
    }

    private function getSenderOrNull(User $owner, ?int $senderId): ?VkAccount
    {
        return $senderId !== null ? $this->vkAccountService->findOneById($owner, $senderId) : null;
    }
}
