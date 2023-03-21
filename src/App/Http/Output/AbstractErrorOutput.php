<?php

declare(strict_types=1);

namespace App\Http\Output;

use SymfonyExtension\Http\Output\AbstractOutput;

abstract class AbstractErrorOutput extends AbstractOutput
{
    public function toArray(): array
    {
        return [
            'success' => false,
            'err' => $this->err(),
        ];
    }

    /**
     * @return mixed[]
     */
    abstract protected function err(): array;
}
