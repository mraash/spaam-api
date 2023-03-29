<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Exception;

use RuntimeException;

/**
 * When api returns error response.
 */
class VkApiException extends RuntimeException
{
    public function __construct(
        private int $vkCode,
        private string $vkMessage,
    ) {
        parent::__construct($vkMessage);
    }

    public function getVkCode(): int
    {
        return $this->vkCode;
    }

    public function getVkMessage(): string
    {
        return $this->vkMessage;
    }
}
