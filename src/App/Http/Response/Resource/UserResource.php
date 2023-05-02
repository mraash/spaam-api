<?php

declare(strict_types=1);

namespace App\Http\Response\Resource;

use App\Domain\Entity\User;
use SymfonyExtension\Http\Resource\AbstractResource;

class UserResource extends AbstractResource
{
    public function __construct(
        private User $user
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->user->getId(),
            'email' => $this->user->getEmail(),
        ];
    }
}
