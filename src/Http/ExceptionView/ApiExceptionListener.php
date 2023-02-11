<?php

declare(strict_types=1);

namespace App\Http\ExceptionView;

use App\Http\Response\Error\ErrorResponse;
use Psr\Log\LoggerInterface;
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
        private ExceptionMutator $exceptionMutator,
        private LoggerInterface $logger,
        private SerializerInterface $serializer,
        private bool $isDebug
    ) {  
    }

    public function onException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        $metadata = $this->exceptionMutator->getExceptionMedatada(get_class($throwable));

        if ($this->isDebug && $metadata->getHttpCode() >= Response::HTTP_INTERNAL_SERVER_ERROR) {
            return;
        }

        $message = $this->exceptionMutator->getMessage($throwable, $metadata);

        $json = $this->serializer->serialize(new ErrorResponse($message), JsonEncoder::FORMAT);
        $response = new JsonResponse($json, $metadata->getHttpCode(), [], true);

        $event->setResponse($response);
    }
}
