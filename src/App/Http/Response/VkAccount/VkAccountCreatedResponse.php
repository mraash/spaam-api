<?php

declare(strict_types=1);

namespace App\Http\Response\VkAccount;

use App\Domain\Entity\VkAccount;

class VkAccountCreatedResponse
{
    public readonly bool $success;

    public function __construct(VkAccount $vkAccount)
    {
        $this->success = true;
    }
}
