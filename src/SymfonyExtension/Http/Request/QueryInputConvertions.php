<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Request;

trait QueryInputConvertions
{
    protected function strToInt(mixed $value): mixed
    {
        if (!is_string($value)) {
            return $value;
        }

        if (preg_match('/^[0-9]+$/', $value) === 1) {
            return intval($value);
        }

        return $value;
    }

    protected function strToBool(mixed $value): mixed
    {
        if (!is_string($value)) {
            return $value;
        }

        if ($value === '1' || $value === 'true') {
            return true;
        }

        if ($value === '' || $value === 'false') {
            return false;
        }

        return $value;
    }
}
