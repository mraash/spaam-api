<?php

declare(strict_types=1);

namespace App\Http\Output;

class IdOutput extends AbstractSuccessOutput
{
    public function __construct(
        private int $id,
    ) {
    }

    protected function payload(): array
    {
        return [
            /** @phpstan-ignore-next-line */
            'id' => $this->id,
        ];
    }
}
