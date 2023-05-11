<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Response\Info;

use App\Integration\VKontakte\Exception\ContractException;

class GroupInfo extends AbstractInfo
{
    public function __construct(
        public readonly int $id,
        public readonly bool $canPost,
    ) {
    }

    public static function fromArray(array $data): self
    {
        $id = $data['id'] ?? throw new ContractException();
        $canPost = $data['can_post'] ?? throw new ContractException();

        return new self(
            (int) $id,
            (bool) $canPost,
        );
    }
}
