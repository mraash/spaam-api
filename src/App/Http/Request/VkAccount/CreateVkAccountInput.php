<?php

declare(strict_types=1);

namespace App\Http\Request\VkAccount;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Attribute\Input\AsQueryInput;
use SymfonyExtension\Http\Request\QueryInputConvertions;

#[AsQueryInput]
class CreateVkAccountInput
{
    use QueryInputConvertions;

    #[NotBlank]
    #[Type('string')]
    private mixed $access_token;

    #[NotBlank]
    #[Type('integer')]
    private mixed $user_id;

    // #[NotBlank]
    // #[Type('integer')]
    // private mixed $expires_in;

    public function __construct(mixed $access_token, mixed $user_id)
    {
        $this->access_token = $access_token;
        $this->user_id = $this->strToInt($user_id);
    }

    public function getAccessToken(): string
    {
        /** @var string */
        return $this->access_token;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }
}
