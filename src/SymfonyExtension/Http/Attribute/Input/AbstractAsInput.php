<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Attribute\Input;

abstract class AbstractAsInput
{
    public function __construct(
        public bool $validate = true,
    ) {
    }
}
