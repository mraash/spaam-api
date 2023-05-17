<?php

declare(strict_types=1);

namespace App\Http\Security\Listener;

use App\Http\Response\Output\ErrorOutput;
use Gesdinet\JWTRefreshTokenBundle\Event\RefreshAuthenticationFailureEvent;
use Gesdinet\JWTRefreshTokenBundle\Event\RefreshTokenNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class RefreshFailureListener
{
    public function onTokenInvalid(RefreshAuthenticationFailureEvent $event): void
    {
        // todo: Make this as validation exception
        $output = new ErrorOutput('Invalid refresh token.');

        $response = new JsonResponse($output->toArray(), 401);

        $event->setResponse($response);
    }

    public function onTokenNotFound(RefreshTokenNotFoundEvent $event): void
    {
        // todo: Make this as validation exception
        $output = new ErrorOutput('Refresh token not found.');

        $response = new JsonResponse($output->toArray(), 401);

        $event->setResponse($response);
    }
}
