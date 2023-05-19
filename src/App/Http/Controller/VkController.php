<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Domain\Service\Vk\VkService;
use App\Domain\Service\VkAccount\VkAccountService;
use App\Http\Request\Input\VK\SendMessageInput;
use App\Http\Response\Output\SuccessOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VkController extends AbstractController
{
    public function __construct(
        private VkAccountService $vkAccountService,
        private VkService $vkService,
    ) {
    }

    #[Route('/v1/vk/send', methods: 'POST', name: 'api.v1.vk.send')]
    public function send(SendMessageInput $input): JsonResponse
    {
        $senderId = $input->getSenderId();
        $recipient = $input->getRecipient();
        $text = $input->getText();

        $user = $this->getUser();

        $sender = $this->vkAccountService->findOneById($user, $senderId);

        $this->vkService->sendMessage($sender, $recipient, $text);

        return $this->jsonOutput(new SuccessOutput());
    }
}
