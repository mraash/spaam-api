<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Input\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use SymfonyExtension\Http\Input\Input\AbstractInput;
use SymfonyExtension\Http\Input\Validator\Exception\ValidationException;

class InputValidator
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
    }

    public function getViolations(AbstractInput $input): ViolationList
    {
        $params = $input->params();
        $rules = $input->rules();

        $constraintViolationList = $this->validator->validate($params, $rules);

        return ViolationList::fromConstraintViolationList($constraintViolationList);
    }

    /**
     * @throws ValidationException
     */
    public function validate(AbstractInput $input): void
    {
        $constraintViolationList = $this->getViolations($input);

        if (!$constraintViolationList->isEmpty()) {
            throw new ValidationException($constraintViolationList);
        }
    }
}
