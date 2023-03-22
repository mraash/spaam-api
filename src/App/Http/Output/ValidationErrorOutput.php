<?php

declare(strict_types=1);

namespace App\Http\Output;

use SymfonyExtension\Http\Input\Validator\Violation;
use SymfonyExtension\Http\Input\Validator\ViolationList;

class ValidationErrorOutput extends AbstractErrorOutput
{
    public function __construct(
        private string $message,
        private ViolationList $violations,
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
    private function getPrettyViolation(Violation $violation): array
    {
        return [
            'propertyPath' => $violation->getPropertyPath(),
            'message' => $violation->getMessage(),
        ];
    }
}
