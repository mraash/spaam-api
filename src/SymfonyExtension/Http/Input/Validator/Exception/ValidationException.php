<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Input\Validator\Exception;

use RuntimeException;
use SymfonyExtension\Http\Input\Validator\ViolationList;

class ValidationException extends RuntimeException
{
    public function __construct(
        private ViolationList $violations,
    ) {
        parent::__construct('Invalid request.');
    }

    public function getViolations(): ViolationList
    {
        return $this->violations;
    }
}
