<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Input\Validator;

use Symfony\Component\Validator\ConstraintViolationInterface;

class Violation
{
    public function __construct(
        private string $propertyPath,
        private string $message
    ) {
    }

    public static function fromConstraintViolation(ConstraintViolationInterface $constraintViolation): self
    {
        return new self(
            $constraintViolation->getPropertyPath(),
            (string) $constraintViolation->getMessage(),
        );
    }

    public function getPropertyPath(): string
    {
        return $this->propertyPath;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
