<?php

declare(strict_types=1);

namespace App\Integration\VKontakte;

use App\Integration\VKontakte\Interface\VkApiInterface;
use App\Integration\VKontakte\Part\AuthApi\AuthApi;
use App\Integration\VKontakte\Part\GoupsApi\GroupsApi;
use App\Integration\VKontakte\Part\WallApi\WallApi;

class VkApi implements VkApiInterface
{
    public function __construct(
        private AuthApi $auth,
        private WallApi $wall,
        private GroupsApi $groups,
    ) {
    }

    public function auth(): AuthApi
    {
        return $this->auth;
    }

    public function wall(): WallApi
    {
        return $this->wall;
    }

    public function groups(): GroupsApi
    {
        return $this->groups;
    }
}
