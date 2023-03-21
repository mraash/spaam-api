<?php

declare(strict_types=1);

namespace App\Http\Output;

use SymfonyExtension\Http\Output\AbstractOutput;

class ErrorOutput extends AbstractErrorOutput
{
    public function __construct(
        private string $message,
    ) {
    }

    protected function err(): array
    {
        return [
            'message' => $this->message,
        ];
    }
}
