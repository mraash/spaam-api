<?php

declare(strict_types=1);

namespace App\Http\Security\Listener;

use App\Domain\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JwtCreatedListener
{
    public function __invoke(JWTCreatedEvent $event): void
    {
        /** @var User */
        $user = $event->getUser();
        $payload = $event->getData();

        $payload['id'] = $user->getId();

        $event->setData($payload);
    }
}
