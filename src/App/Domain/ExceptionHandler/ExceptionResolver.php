<?php

declare(strict_types=1);

namespace App\Http\ExceptionHandler\Uncaught;
namespace App\Domain\ExceptionHandler;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Retrieves metadata from an exception.
 */
class ExceptionResolver
{
    /** 
     * @var array<string,ExceptionMetadata>
     * @phpstan-var array<class-string,ExceptionMetadata>
     */
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

            if (!is_int($code)) {
                throw new InvalidArgumentException('$rawMetadataList.*.httpCode should be of integer type.');
            }

            if (!is_bool($hidden)) {
                throw new InvalidArgumentException('$rawMetadataList.*.visible should be of boolean type.');
            }

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

        // Return default metadata
        return new ExceptionMetadata(Response::HTTP_INTERNAL_SERVER_ERROR, false);
    }

    public function getMessage(Throwable $throwable): string
    {
        $metadata = $this->getExceptionMedatada(get_class($throwable));

        return $metadata->isVisible()
            ? $throwable->getMessage()
            : Response::$statusTexts[$metadata->getHttpCode()]
        ;
    }
}
