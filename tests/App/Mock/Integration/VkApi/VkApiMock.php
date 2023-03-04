<?php

declare(strict_types=1);

namespace Tests\App\Mock\Integration\VkApi;

use App\Integration\VkApi\VkApiInterface;

class VkApiMock implements VkApiInterface
{
    public function getAuthLink(int $appId, ?string $redirectUrl = null): string
    {
        return 'https://mock-link.com';
    }
}
