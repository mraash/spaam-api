<?php

declare(strict_types=1);

namespace App\Http\ExceptionHandler\Uncaught;

use App\Http\Response\Error\ErrorResponse;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsEventListener(ExceptionEvent::class, method: 'onException', priority: 10)]
class ApiExceptionListener
{
    public function __construct(
        private ExceptionResolver $exceptionResolver,
        private SerializerInterface $serializer,
        private bool $isDebug
    ) {
    }

    public function onException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        $metadata = $this->exceptionResolver->getExceptionMedatada(get_class($throwable));

        $message = $this->exceptionResolver->getMessage($throwable);

        $responseModel = new ErrorResponse($message);

        if ($this->isDebug && $metadata->getHttpCode() >= Response::HTTP_INTERNAL_SERVER_ERROR) {
            $responseModel = new ErrorResponse($message, [
                '_debug' => [
                    'message' => $throwable->getMessage(),
                    'file' => $throwable->getFile(),
                    'line' => $throwable->getLine(),
                    'trace' => $throwable->getTrace(),
                ]
            ]);
        }

        $json = $this->serializer->serialize($responseModel, JsonEncoder::FORMAT);
        $response = new JsonResponse($json, $metadata->getHttpCode(), [], true);

        $event->setResponse($response);
    }
}
