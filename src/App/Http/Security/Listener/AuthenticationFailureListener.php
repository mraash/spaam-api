<?php

declare(strict_types=1);

namespace App\Http\Security\Listener;

use App\Http\Response\Output\ErrorOutput;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthenticationFailureListener
{
    public function onInvalidCredentials(AuthenticationFailureEvent $event): void
    {
        // TODO: Make this as validation exception
        $output = new ErrorOutput('Invalid credentials.');

        $response = new JsonResponse($output->toArray(), 401);

        $event->setResponse($response);
    }

    public function onInvalidJwt(JWTInvalidEvent $event): void
    {
        $output = new ErrorOutput('Invalid jwt token.');

        $response = new JsonResponse($output->toArray(), 401);

        $event->setResponse($response);
    }

    public function onJWTNotFound(JWTNotFoundEvent $event): void
    {
        $output = new ErrorOutput('Jwt token not found.');

        $response = new JsonResponse($output->toArray(), 401);

        $event->setResponse($response);
    }

    public function onJWTExpired(JWTExpiredEvent $event): void
    {
        $output = new ErrorOutput('Jwt token expired.');

        $response = new JsonResponse($output->toArray(), 401);

        $event->setResponse($response);
    }
}
