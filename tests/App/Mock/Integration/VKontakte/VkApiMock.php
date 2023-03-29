<?php

declare(strict_types=1);

namespace Tests\App\Mock\Integration\VKontakte;

use App\Integration\VKontakte\Info\GroupInfo;
use App\Integration\VKontakte\Interface\AuthApiInterface;
use App\Integration\VKontakte\Interface\GroupsApiInterface;
use App\Integration\VKontakte\Interface\VkApiInterface;
use App\Integration\VKontakte\Interface\WallApiInterface;
use App\Integration\VKontakte\Part\GoupsApi\Output\GroupOutput;
use App\Integration\VKontakte\Part\WallApi\Output\PostIdOutput;

class VkApiMock implements VkApiInterface
{
    public function auth(): AuthApiInterface
    {
        return new class implements AuthApiInterface
        {
            public function getAuthLink(int $appId, ?string $redirectUrl = null): string
            {
                return 'https://mock-link.com';
            }
        };
    }

    public function wall(): WallApiInterface
    {
        return new class implements WallApiInterface
        {
            public function postToGroup(string $token, int $groupId, string $message): PostIdOutput
            {
                return new PostIdOutput(1);
            }
        };
    }

    public function groups(): GroupsApiInterface
    {
        return new class implements GroupsApiInterface
        {
            public function getById(string $token, int|string $id): GroupOutput
            {
                return new GroupOutput(new GroupInfo(1));
            }
        };
    }
}
