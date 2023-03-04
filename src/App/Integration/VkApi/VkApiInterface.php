<?php

declare(strict_types=1);

namespace App\Integration\VkApi;

interface VkApiInterface
{
    public function getAuthLink(int $appId, string $redirectUrl = null): string;
}
