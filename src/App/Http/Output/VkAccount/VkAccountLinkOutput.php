<?php

declare(strict_types=1);

namespace App\Http\Output\VkAccount;

use App\Http\Output\AbstractSuccessOutput;

class VkAccountLinkOutput extends AbstractSuccessOutput
{
    public function __construct(
        private string $link,
    ) {
    }

    protected function payload(): array
    {
        return [
            'link' => $this->link,
        ];
    }
}
