<?php

declare(strict_types=1);

namespace App\Http\Response\VkAccount;

class VkAccountDeletedResponse
{
    public readonly bool $success;

    public function __construct()
    {
        $this->success = true;
    }
}
