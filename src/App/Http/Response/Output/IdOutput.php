<?php

declare(strict_types=1);

namespace App\Http\Response\Output;

class IdOutput extends AbstractSuccessOutput
{
    public function __construct(
        private int $id,
    ) {
    }

    protected function payload(): array
    {
        return [
            'id' => $this->id,
        ];
    }
}
