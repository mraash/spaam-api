<?php

declare(strict_types=1);

namespace App\Http\Response\Output\VkAccount;

use App\Http\Response\Output\AbstractSuccessOutput;

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
