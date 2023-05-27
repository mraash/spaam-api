<?php

declare(strict_types=1);

namespace App\Http\Request\Input\VkAccount;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Input\Input\AbstractBaseInput;

class CreateVkAccountInput extends AbstractBaseInput
{
    public static function allowedRequestTypes(): array
    {
        return [
            self::REQUEST_TYPE_GET_QUERY,
            self::REQUEST_TYPE_POST_QUERY,
        ];
    }

    protected static function fields(): array
    {
        return [
            'access_token' => new Required([
                new NotBlank(),
                new Type('string'),
            ]),
            'user_id' => new Required([
                new NotBlank(),
                new Type('integer'),
            ]),
            'expires_in' => new Optional(),
        ];
    }

    public function getAccessToken(): string
    {
        /** @var string */
        return $this->getParam('access_token');
    }

    public function getUserId(): int
    {
        /** @var int */
        return $this->getParam('user_id');
    }
}
