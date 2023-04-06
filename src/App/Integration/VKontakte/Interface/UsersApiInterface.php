<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Interface;

use App\Integration\VKontakte\Part\UsersApi\Output\UserOutput;

interface UsersApiInterface
{
    public function get(string $token, int $id = null): UserOutput;
}
