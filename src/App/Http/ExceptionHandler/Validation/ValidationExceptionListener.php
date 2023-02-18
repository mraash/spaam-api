<?php

declare(strict_types=1);

namespace App\Http\ExceptionHandler\Validation;

use SymfonyExtension\Http\ArgumentResolver\RequestBody\Exception\ValidationException;
use App\Http\Response\Error\ErrorResponse;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[AsEventListener(ExceptionEvent::class, method: 'onException', priority: 15)]
class ValidationExceptionListener
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public function onException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        if (!($throwable instanceof ValidationException)) {
            return;
        }

        $message = $throwable->getMessage();

        $responseModel = new ErrorResponse($message, [
            'violations' => $this->getPrettyViolations($throwable->getViolations()),
        ]);

        $json = $this->serializer->serialize($responseModel, JsonEncoder::FORMAT);

        $response = new JsonResponse($json, Response::HTTP_BAD_REQUEST, [], true);

        $event->setResponse($response);
    }

    private function getPrettyViolations(ConstraintViolationListInterface $violations): array
    {
        $violationsList = [];

        foreach ($violations as $violation) {
            $violationsList[] = $this->getPrettyViolation($violation);
        }

        return $violationsList;
    }

    private function getPrettyViolation(ConstraintViolationInterface $violation): array
    {
        return [
            'propertyPath' => $violation->getPropertyPath(),
            'message' => $violation->getMessage(),
        ];
    }
}
