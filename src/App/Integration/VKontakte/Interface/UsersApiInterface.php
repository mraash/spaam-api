<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Interface;

use App\Integration\VKontakte\Response\Output\User\UserOutput;

interface UsersApiInterface
{
    public function get(string $token, int $id = null): UserOutput;
}
