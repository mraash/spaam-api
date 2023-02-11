<?php

declare(strict_types=1);

namespace App\Http\ExceptionView;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ExceptionMutator
{
    /** @var array<string,ExceptionMetadata> */
    /** @phpstan-var array<class-string,ExceptionMetadata> */
    private array $metadataList = [];

    /**
     * @param array<array<mixed>> $rawMetadataList  Associative array of exception metadata. Key
     *  in this array is exception class string, and value is associative array of elements:
     *      - httpCode => (int)
     *      - visible => (bool)
     *  This metadata lives in config/services.yaml > parameters > exceptions.
     */
    public function __construct(array $rawMetadataList)
    {
        foreach ($rawMetadataList as $class => $exceptionData) {
            $code = $exceptionData['httpCode'] ?? null;
            $hidden = $exceptionData['visible'] ?? null;

            $this->metadataList[$class] = new ExceptionMetadata($code, $hidden);
        }
    }

    public function getExceptionMedatada(string $throwableClass): ExceptionMetadata
    {
        foreach ($this->metadataList as $class => $metadata) {
            if ($throwableClass === $class || is_subclass_of($throwableClass, $class)) {
                return $metadata;
            }
        }

        return ExceptionMetadata::fromCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function getMessage(Throwable $throwable, ExceptionMetadata $metadata): string
    {
        return $metadata->isVisible()
            ? $throwable->getMessage()
            : Response::$statusTexts[$metadata->getHttpCode()]
        ;
    }
}
