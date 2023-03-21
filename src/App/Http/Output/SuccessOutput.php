<?php

declare(strict_types=1);

namespace App\Http\Output;

use SymfonyExtension\Http\Output\AbstractOutput;

class SuccessOutput extends AbstractOutput
{
    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        return [
            'success' => true,
        ];
    }
}
