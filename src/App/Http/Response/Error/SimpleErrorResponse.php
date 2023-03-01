<?php

declare(strict_types=1);

namespace App\Http\Response\Error;

class SimpleErrorResponse
{
    public function __construct(
        private string $message,
    ) {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
