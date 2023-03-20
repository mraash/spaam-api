<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Input\Input;

abstract class AbstractJsonBodyInput extends AbstractBaseInput
{
    public static function allowedRequestTypes(): array
    {
        return [self::REQUEST_TYPE_JSON_BODY];
    }
}
