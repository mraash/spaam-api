<?php

declare(strict_types=1);

namespace App\Http\Response\Output;

use SymfonyExtension\Http\Output\AbstractOutput;

abstract class AbstractSuccessOutput extends AbstractOutput
{
    public function toArray(): array
    {
        return [
            'success' => true,
            'payload' => $this->payload(),
        ];
    }

    /**
     * @return mixed[]
     */
    abstract protected function payload(): array;
}
