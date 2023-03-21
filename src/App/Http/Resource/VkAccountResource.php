<?php

declare(strict_types=1);

namespace App\Http\Resource;

use App\Domain\Entity\VkAccount;
use SymfonyExtension\Http\Resource\AbstractResource;

class VkAccountResource extends AbstractResource
{
    public function __construct(
        private VkAccount $vkAccount,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->vkAccount->getId(),
            'vkId' => $this->vkAccount->getVkId(),
        ];
    }
}
