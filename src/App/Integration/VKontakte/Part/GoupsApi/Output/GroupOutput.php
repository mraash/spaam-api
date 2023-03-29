<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Part\GoupsApi\Output;

use App\Integration\VKontakte\Exception\ContractException;
use App\Integration\VKontakte\Info\GroupInfo;
use App\Integration\VKontakte\Part\AbstractOutput;

class GroupOutput extends AbstractOutput
{
    public function __construct(
        public readonly GroupInfo $groupInfo,
    ) {
    }

    protected static function fromData(array $data): self
    {
        $groupData = $data[0] ?? throw new ContractException();

        if (!is_array($groupData)) {
            throw new ContractException();
        }

        return new self(GroupInfo::fromArray($groupData));
    }
}
