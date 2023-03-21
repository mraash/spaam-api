<?php

declare(strict_types=1);

namespace App\Http\ExceptionHandler\Uncaught;

use App\Http\Output\ErrorOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ApiExceptionListener
{
    public function __construct(
        private ExceptionResolver $exceptionResolver,
        private bool $isDebug,
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

        $output = new ErrorOutput($message);

        $response = new JsonResponse($output->toArray(), $metadata->getHttpCode());

        $event->setResponse($response);
    }
}
