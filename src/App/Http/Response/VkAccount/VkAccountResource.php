<?php

declare(strict_types=1);

namespace App\Http\Response\VkAccount;

use App\Domain\Entity\VkAccount;

class VkAccountResource
{
    public readonly int $id;

    public readonly int $vkId;

    public function __construct(VkAccount $vkAccount)
    {
        $this->id = $vkAccount->getId();
        $this->vkId = $vkAccount->getVkId();
    }
}
