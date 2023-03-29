<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Interface;

interface AuthApiInterface
{
    public function getAuthLink(int $appId, string $redirectUrl = null): string;
}
