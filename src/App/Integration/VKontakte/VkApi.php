<?php

declare(strict_types=1);

namespace App\Integration\VKontakte;

use App\Integration\VKontakte\Interface\UsersApiInterface;
use App\Integration\VKontakte\Interface\VkApiInterface;
use App\Integration\VKontakte\Part\AuthApi;
use App\Integration\VKontakte\Part\GroupsApi;
use App\Integration\VKontakte\Part\UsersApi;
use App\Integration\VKontakte\Part\WallApi;

class VkApi implements VkApiInterface
{
    public function __construct(
        private AuthApi $auth,
        private WallApi $wall,
        private GroupsApi $groups,
        private UsersApi $users,
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

    public function users(): UsersApiInterface
    {
        return $this->users;
    }
}
