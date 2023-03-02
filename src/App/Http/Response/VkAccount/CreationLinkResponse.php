<?php

declare(strict_types=1);

namespace App\Http\Response\VkAccount;

class CreationLinkResponse
{
    public function __construct(
        public readonly string $link,
    ) {
    }
}
