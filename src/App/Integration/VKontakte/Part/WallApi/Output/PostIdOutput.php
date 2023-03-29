<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Part\WallApi\Output;

use App\Integration\VKontakte\Exception\ContractException;
use App\Integration\VKontakte\Part\AbstractOutput;

class PostIdOutput extends AbstractOutput
{
    public function __construct(
        public readonly int $id,
    ) {
    }

    protected static function fromData(array $data): self
    {
        $id = $data['post_id'];

        if (!is_int($id)) {
            throw new ContractException();
        }

        return new self($id);
    }
}
