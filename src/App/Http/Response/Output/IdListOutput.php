<?php

declare(strict_types=1);

namespace App\Http\Response\Output;

class IdListOutput extends AbstractSuccessOutput
{
    /**
     * @param int[] $ids
     */
    public function __construct(
        private array $ids,
    ) {
    }

    protected function payload(): array
    {
        return [
            'ids' => $this->ids,
        ];
    }
}
