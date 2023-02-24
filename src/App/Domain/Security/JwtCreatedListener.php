<?php

declare(strict_types=1);

namespace App\Domain\Security;

use App\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedListener
{
    public function __invoke(JWTCreatedEvent $event): void
    {
        /** @var User */
        $user = $event->getUser();

        $payload = [
            'id' => $user->getId(),
            'username' => $user->getEmail(),
            'roles' => $user->getRoles(),
        ];

        $event->setData($payload);
    }
}
