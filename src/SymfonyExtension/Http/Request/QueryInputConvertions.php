<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Request;

trait QueryInputConvertions
{
    protected function strToInt(string $value): string|int
    {
        if (preg_match('/^[0-9]+$/', $value) === 1) {
            return $value + 0;
        }

        return $value;
    }

    protected function strToBool(string $value): string|bool
    {
        if ($value === '1' || $value === 'true') {
            return true;
        }

        if ($value === '' || $value === 'false') {
            return false;
        }

        return $value;
    }
}
