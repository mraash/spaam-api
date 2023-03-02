<?php

declare(strict_types=1);

namespace App\Outside\VkApi;

class VkApi
{
    private const API_VERSION = '5.131';

    public function getAuthLink(int $appId, string $redirectUrl = null): string
    {
        $query = [
            'client_id' => $appId,
            'display' => 'page',
            'scope' => 'messages,offline',
            'response_type' => 'token',
            'v' => self::API_VERSION,
        ];

        if ($redirectUrl) {
            $query['redirect_url'] = $redirectUrl;
        }

        return 'https://oauth.vk.com/authorize?' . http_build_query($query);
    }
}
