<?php

declare(strict_types=1);

namespace App\Http\Output;

use Stringable;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use SymfonyExtension\Http\Output\AbstractOutput;

class ValidationErrorOutput extends AbstractErrorOutput
{
    public function __construct(
        private string $message,
        private ConstraintViolationListInterface $violations,
    ) {
    }

    protected function err(): array
    {
        return [
            'message' => $this->message,
            'violations' => $this->getViolationArray(),
        ];
    }

    /**
     * @return array<int,array<string,string>>
     */
    private function getViolationArray(): array
    {
        $violationList = [];

        foreach ($this->violations as $violation) {
            $violationList[] = $this->getPrettyViolation($violation);
        }

        return $violationList;
    }

    /**
     * @return array<string,string>
     */
    private function getPrettyViolation(ConstraintViolationInterface $violation): array
    {
        $propertyPath = $violation->getPropertyPath();
        $message = $violation->getMessage();

        if ($message instanceof Stringable) {
            $message = $message->__toString();
        }

        return [
            'propertyPath' => $propertyPath,
            'message' => $message,
        ];
    }
}
