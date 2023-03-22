<?php

declare(strict_types=1);

namespace App\Http\Security\Listener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{
    public function onSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $event->setData([
            'success' => true,
            'data' => $event->getData(),
        ]);
    }
}
