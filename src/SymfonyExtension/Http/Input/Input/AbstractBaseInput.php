<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Input\Input;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Existence;

abstract class AbstractBaseInput extends AbstractInput
{
    public static function rules(): Collection
    {
        return new Collection(static::fields());
    }

    /**
     * @return array<string,Existence>
     */
    abstract protected static function fields(): array;
}
