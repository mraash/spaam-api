<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Response\Info;

use App\Integration\VKontakte\Exception\ContractException;

class UserInfo extends AbstractInfo
{
    public function __construct(
        public readonly int $id,
        public readonly string $domain,
        public readonly string $firstName,
        public readonly string $lastName,
    ) {
    }

    public static function fromArray(array $data): UserInfo
    {
        $id = $data['id'] ?? throw new ContractException();
        $domain = $data['domain'] ?? throw new ContractException();
        $firstName = $data['first_name'] ?? throw new ContractException();
        $lastName = $data['last_name'] ?? throw new ContractException();

        return new self((int) $id, (string) $domain, (string) $firstName, (string) $lastName);
    }
}
