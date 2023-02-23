<?php

declare(strict_types=1);

namespace App\Http\ExceptionHandler\Uncaught;

use App\Http\Response\Error\ErrorResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class ApiExceptionListener
{
    public function __construct(
        private ExceptionResolver $exceptionResolver,
        private SerializerInterface $serializer,
        private bool $isDev,
        private bool $isDebug
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        if ($this->isDebug) {
            return;
        }

        $throwable = $event->getThrowable();
        $metadata = $this->exceptionResolver->getExceptionMedatada(get_class($throwable));

        $message = $this->exceptionResolver->getMessage($throwable);

        $responseModel = new ErrorResponse($message);

        if ($this->isDev) {
            $responseModel = new ErrorResponse($message, [
                '_debug' => [
                    'message' => $throwable->getMessage(),
                    'class' => $throwable::class,
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
