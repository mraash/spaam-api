<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Interface;

interface VkApiInterface
{
    public function auth(): AuthApiInterface;

    public function wall(): WallApiInterface;

    public function groups(): GroupsApiInterface;

    public function users(): UsersApiInterface;
}
