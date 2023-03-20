<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Input\TypeConverter;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Existence;
use Symfony\Component\Validator\Constraints\Type;

/**
 * Class that converts query string param types.
 */
class TypeConverter
{
    /**
     * @param mixed[] $params
     *
     * @return mixed[]
     */
    public function convertTypes(array $params, Collection $rules): array
    {
        $convertedParams = $params;

        /** @var array<string,Existence> */
        $fields = $rules->fields;

        foreach ($fields as $key => $fieldRules) {
            if (!isset($convertedParams[$key])) {
                continue;
            }

            /** @var Constraint[] */
            $constraints = $fieldRules->constraints;

            foreach ($constraints as $constraint) {
                if ($constraint instanceof Type) {
                    $convertedParams[$key] = $this->convertType($params[$key], $constraint);
                }
            }
        }

        return $convertedParams;
    }

    public function convertType(mixed $value, Type $type): mixed
    {
        // TODO: make this more beatiful

        if (!is_string($value)) {
            return $value;
        }

        if ($type->type === 'integer') {
            if (preg_match('/[0-9]+/', $value)) {
                return (int) $value;
            }
        }

        if ($type->type === 'boolean') {
            if ($value === '1' || $value === 'on' || $value === 'true') {
                return true;
            }

            if ($value === '0' || $value === '' || $value === 'false') {
                return false;
            }
        }

        return $value;
    }
}
