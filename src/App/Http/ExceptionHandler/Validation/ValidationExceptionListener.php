<?php

declare(strict_types=1);

namespace App\Http\ExceptionHandler\Validation;

use App\Http\Output\ValidationErrorOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use SymfonyExtension\Http\Input\Builder\Exception\ValidationException;

class ValidationExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if (!($throwable instanceof ValidationException)) {
            return;
        }

        $message = $throwable->getMessage();

        $output = new ValidationErrorOutput($message, $throwable->getViolations());

        $response = new JsonResponse($output->toArray(), Response::HTTP_BAD_REQUEST);

        $event->setResponse($response);
    }
}
