<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Output;

abstract class AbstractOutput
{
    /**
     * @return mixed[]
     */
    abstract public function toArray(): array;
}
