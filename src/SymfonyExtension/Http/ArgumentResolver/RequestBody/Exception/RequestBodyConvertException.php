<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\ArgumentResolver\RequestBody\Exception;

use RuntimeException;
use Throwable;

class RequestBodyConvertException extends RuntimeException
{
    public function __construct(
        private Throwable $serializationException
    ) {
        parent::__construct('Invalid request format.');
    }

    public function getSerializationException(): Throwable
    {
        return $this->serializationException;
    }
}
