<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Domain\Service\SpamPanel\SpamPanelService;
use App\Http\Output\ResourceListOutput;
use App\Http\Output\ResourceOutput;
use App\Http\Output\SuccessOutput;
use App\Http\Request\SpamPanel\CreateSpamPanelInput;
use App\Http\Request\SpamPanel\UpdateSpamPanelInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/v1/spam-panels', methods: 'POST', name: 'api.v1.spamPanels.create')]
    public function create(CreateSpamPanelInput $input): JsonResponse
    {
        $senderId = $input->getSenderId();
        $recipient = $input->getRecipient();
        $texts = $input->getTexts();
        $timers = $input->getTimers();

        $user = $this->getUser();

        $this->spamPanelService->create($user, $senderId, $recipient, $texts, $timers);

        return $this->jsonOutput(new SuccessOutput());
    }

    #[Route('/v1/spam-panels/{id<\d+>}', methods: 'PUT', name: 'api.v1.spamPanels.update')]
    public function update(UpdateSpamPanelInput $input, int $id): JsonResponse
    {
        $senderId = $input->getSenderId();
        $recipient = $input->getRecipient();
        $texts = $input->getTexts();
        $timers = $input->getTimers();

        $user = $this->getUser();
        $panel = $this->spamPanelService->findOneById($user, $id);

        $this->spamPanelService->updateWhole($panel, $senderId, $recipient, $texts, $timers);

        return $this->jsonOutput(new SuccessOutput());
    }

    #[Route('/v1/spam-panels/{id<\d+>}', methods: 'DELETE', name: 'api.v1.spamPanels.delete')]
    public function delete(int $id): JsonResponse
    {
        $user = $this->getUser();

        $this->spamPanelService->delete($user, $id);

        return $this->jsonOutput(new SuccessOutput());
    }
}
