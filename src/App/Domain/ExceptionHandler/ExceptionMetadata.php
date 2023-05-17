<?php

declare(strict_types=1);

namespace App\Http\ExceptionHandler\Uncaught;
namespace App\Domain\ExceptionHandler;

/**
 * Dto class for ExceptionResolver
 */
class ExceptionMetadata
{
    public function __construct(
        private int $httpCode,
        private bool $isVisible,
    ) {
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function isVisible(): bool
    {
        return $this->isVisible;
    }
}
