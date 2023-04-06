<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Part\UsersApi\Output;

use App\Integration\VKontakte\Exception\ContractException;
use App\Integration\VKontakte\Info\UserInfo;
use App\Integration\VKontakte\Part\AbstractOutput;

class UserOutput extends AbstractOutput
{
    public function __construct(
        public readonly UserInfo $userInfo,
    ) {
    }

    protected static function fromData(array $data): AbstractOutput
    {
        $userData = $data[0] ?? throw new ContractException();

        if (!is_array($userData)) {
            throw new ContractException();
        }

        return new self(UserInfo::fromArray($userData));
    }
}
