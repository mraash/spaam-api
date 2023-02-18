<?php

declare(strict_types=1);

namespace App\Http\Response\Error;

class ErrorResponse
{
    /**
     * @param mixed[] $details
     */
    public function __construct(
        private string $message,
        private ?array $details = null,
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return mixed[]
     */
    public function getDetails(): ?array
    {
        return $this->details;
    }
}
