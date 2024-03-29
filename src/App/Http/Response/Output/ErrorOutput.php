<?php

declare(strict_types=1);

namespace App\Http\Response\Output;

use SymfonyExtension\Http\Output\AbstractOutput;

class ErrorOutput extends AbstractErrorOutput
{
    public function __construct(
        private string $message,
    ) {
    }

    protected function error(): array
    {
        return [
            'message' => $this->message,
        ];
    }
}
