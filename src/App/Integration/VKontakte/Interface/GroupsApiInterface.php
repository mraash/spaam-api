<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Interface;

use App\Integration\VKontakte\Part\GoupsApi\Output\GroupOutput;

interface GroupsApiInterface
{
    public function getById(string $token, int|string $id): GroupOutput;
}
