<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Interface;

use App\Integration\VKontakte\Response\Output\Wall\PostIdOutput;

interface WallApiInterface
{
    public function postToGroup(string $token, int $groupId, string $message): PostIdOutput;
}
