<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Response\Output\Wall;

use App\Integration\VKontakte\Exception\ContractException;
use App\Integration\VKontakte\Response\Output\AbstractOutput;

class PostIdOutput extends AbstractOutput
{
    public function __construct(
        public readonly int $postId,
    ) {
    }

    protected static function fromData(array $data): self
    {
        $postId = $data['post_id'];

        if (!is_int($postId)) {
            throw new ContractException();
        }

        return new self($postId);
    }
}
