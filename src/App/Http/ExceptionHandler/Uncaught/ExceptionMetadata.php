<?php

declare(strict_types=1);

namespace App\Http\ExceptionHandler\Uncaught;

class ExceptionMetadata
{
    public function __construct(
        private int $httpCode,
        private bool $isVisible
    ) {
    }

    public static function fromCode(int $httpCode): self
    {
        return new self($httpCode, false);
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
