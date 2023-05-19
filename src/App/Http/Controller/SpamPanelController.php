<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Domain\Service\SpamPanel\SpamPanelService;
use App\Http\Request\Input\IdListInput;
use App\Http\Response\Output\ResourceListOutput;
use App\Http\Response\Output\ResourceOutput;
use App\Http\Request\Input\SpamPanel\CreateSpamPanelInput;
use App\Http\Request\Input\SpamPanel\CreateSpamPanelListInput;
use App\Http\Request\Input\SpamPanel\PatchSpamPanelInput;
use App\Http\Request\Input\SpamPanel\PutSpamPanelInput;
use App\Http\Request\Input\SpamPanel\PutSpamPanelListInput;
use App\Http\Response\Output\IdListOutput;
use App\Http\Response\Output\IdOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyExtension\Domain\Support\NullArg;

class SpamPanelController extends AbstractController
{
    public function __construct(
        private SpamPanelService $spamPanelService,
    ) {
    }

    #[Route('/v1/spam-panels', methods: 'GET', name: 'api.v1.spamPanels.index')]
    public function index(): JsonResponse
    {
        $user = $this->getUser();

        $panelList = $this->spamPanelService->findAll($user);

        return $this->jsonOutput(new ResourceListOutput($panelList));
    }

    #[Route('/v1/spam-panels/{id<\d+>}', methods: 'GET', name: 'api.v1.spamPanels.single')]
    public function single(int $id): JsonResponse
    {
        $user = $this->getUser();

        $panel = $this->spamPanelService->findOneById($user, $id);

        return $this->jsonOutput(new ResourceOutput($panel));
    }

    #[Route('/v1/spam-panels/list', methods: 'POST', name: 'api.v1.spamPanels.list.create')]
    public function createList(CreateSpamPanelListInput $input): JsonResponse
    {
        $panelList = $input->getItems();

        $user = $this->getUser();

        $createdPanelList = $this->spamPanelService->createList($user, $panelList);

        return $this->jsonOutput(new ResourceListOutput($createdPanelList));
    }

    #[Route('/v1/spam-panels', methods: 'POST', name: 'api.v1.spamPanels.create')]
    public function create(CreateSpamPanelInput $input): JsonResponse
    {
        $senderId = $input->getSenderId();
        $recipient = $input->getRecipient();
        $texts = $input->getTexts();
        $timers = $input->getTimers();

        $user = $this->getUser();

        $panel = $this->spamPanelService->create($user, $senderId, $recipient, $texts, $timers);

        return $this->jsonOutput(new ResourceOutput($panel));
    }

    #[Route('/v1/spam-panels', methods: 'PUT', name: 'api.v1.spamPanels.list.put')]
    public function updateWholeList(PutSpamPanelListInput $input): JsonResponse
    {
        $panelDtoList = $input->getSpamPanelList();

        $user = $this->getUser();

        $panelList = $this->spamPanelService->updateListFully($user, $panelDtoList);

        return $this->jsonOutput(new ResourceListOutput($panelList));
    }

    #[Route('/v1/spam-panels/{id<\d+>}', methods: 'PUT', name: 'api.v1.spamPanels.put')]
    public function updateWhole(PutSpamPanelInput $input, int $id): JsonResponse
    {
        $senderId = $input->getSenderId();
        $recipient = $input->getRecipient();
        $texts = $input->getTexts();
        $timers = $input->getTimers();

        $user = $this->getUser();

        $panel = $this->spamPanelService->updateWhole($user, $id, $senderId, $recipient, $texts, $timers);

        return $this->jsonOutput(new ResourceOutput($panel));
    }

    #[Route('/v1/spam-panels/{id<\d+>}', methods: 'PATCH', name: 'api.v1.spamPanels.patch')]
    public function updatePart(PatchSpamPanelInput $input, int $id): JsonResponse
    {
        $senderId = $input->hasSenderId() ? $input->getSenderId() : new NullArg();
        $recipient = $input->getRecipientOrNull() ?? new NullArg();
        $texts = $input->getTextsOrNull() ?? new NullArg();
        $timers = $input->getTimersOrNull() ?? new NullArg();

        $user = $this->getUser();

        $panel = $this->spamPanelService->updatePart($user, $id, $senderId, $recipient, $texts, $timers);

        return $this->jsonOutput(new ResourceOutput($panel));
    }

    #[Route('/v1/spam-panels', methods: 'DELETE', name: 'api.v1.spamPanels.list.delete')]
    public function deleteList(IdListInput $input): JsonResponse
    {
        $idList = $input->getIdList();

        $user = $this->getUser();

        $this->spamPanelService->deleteList($user, $idList);

        return $this->jsonOutput(new IdListOutput($idList));
    }

    #[Route('/v1/spam-panels/{id<\d+>}', methods: 'DELETE', name: 'api.v1.spamPanels.delete')]
    public function delete(int $id): JsonResponse
    {
        $user = $this->getUser();

        $this->spamPanelService->delete($user, $id);

        return $this->jsonOutput(new IdOutput($id));
    }
}
