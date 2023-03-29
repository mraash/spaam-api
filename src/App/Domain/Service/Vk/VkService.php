<?php

declare(strict_types=1);

namespace App\Domain\Service\Vk;

use App\Domain\Entity\VkAccount;
use App\Domain\Service\Vk\Exception\MessageNotAllowedException;
use App\Domain\Service\Vk\Exception\RecipientNotFoundException;
use App\Integration\VKontakte\Exception\VkApiException;
use App\Integration\VKontakte\Interface\VkApiInterface;

class VkService
{
    public function __construct(
        private VkApiInterface $api,
    ) {
    }

    public function getAuthLink(int $appId, string $redirectUrl = null): string
    {
        return $this->api->auth()->getAuthLink($appId, $redirectUrl);
    }

    public function sendMessage(VkAccount $sender, string $recipientSlug, string $message): void
    {
        try {
            $group = $this->api->groups()->getById($sender->getVkAccessToken(), $recipientSlug)->groupInfo;
        }
        catch (VkApiException $err) {
            if ($err->getVkCode() === 100 && preg_match('/group_id/', $err->getVkMessage())) {
                throw new RecipientNotFoundException($recipientSlug);
            }

            throw $err;
        }

        try {
            $this->api->wall()->postToGroup($sender->getVkAccessToken(), $group->id, $message);
        }
        catch (VkApiException $err) {
            if ($err->getVkCode() === 214) {
                throw new MessageNotAllowedException();
            }

            throw $err;
        }
    }
}
