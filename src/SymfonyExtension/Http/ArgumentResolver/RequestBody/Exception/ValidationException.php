<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\ArgumentResolver\RequestBody\Exception;

use RuntimeException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends RuntimeException
{
    public function __construct(
        private ConstraintViolationListInterface $violations
    ) {
        parent::__construct('Invalid request.');
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
