<?php

declare(strict_types=1);

namespace App\Http\Response\Auth;

use App\Domain\Entity\User;

class RegistrationResponse
{
    public readonly int $id;
    public readonly string $email;

    public function __construct(User $user)
    {
        $this->id = $user->getId();
        $this->email = $user->getEmail();
    }
}
