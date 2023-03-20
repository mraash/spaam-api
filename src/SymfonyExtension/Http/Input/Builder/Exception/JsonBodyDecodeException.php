<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Input\Builder\Exception;

use RuntimeException;

class JsonBodyDecodeException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Request body is not json object.');
    }
}
