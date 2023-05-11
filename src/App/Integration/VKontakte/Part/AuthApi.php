<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Part;

use App\Integration\VKontakte\Interface\AuthApiInterface;

/**
 * @internal for App\Integration\VKontakte
 */
class AuthApi implements AuthApiInterface
{
    public function __construct(
        private readonly string $vkApiVersion,
    ) {
    }

    public function getAuthLink(int $appId, string $redirectUrl = null): string
    {
        $query = [
            'client_id' => $appId,
            'display' => 'page',
            'scope' => 'messages,groups,offline',
            'response_type' => 'token',
            'v' => $this->vkApiVersion,
        ];

        if ($redirectUrl) {
            $query['redirect_url'] = $redirectUrl;
        }

        return 'https://oauth.vk.com/authorize?' . http_build_query($query);
    }
}
