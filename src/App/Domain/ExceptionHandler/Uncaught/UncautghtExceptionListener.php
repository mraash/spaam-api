<?php

declare(strict_types=1);

namespace App\Domain\ExceptionHandler\Uncaught;

use App\Domain\ExceptionHandler\ExceptionResolver;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class UncautghtExceptionListener
{
    public function __construct(
        private LoggerInterface $logger,
        private ExceptionResolver $exceptionResolver,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        $metadata = $this->exceptionResolver->getExceptionMedatada(get_class($throwable));

        if ($metadata->getHttpCode() < 500) {
            return;
        }

        $message = $throwable::class;

        if ($throwable->getCode() !== 0) $message .= "({$throwable->getCode()})";
        if ($throwable->getMessage() !== '') $message .= ": {$throwable->getMessage()}";

        $this->logger->error($message, $throwable->getTrace());
    }
}
