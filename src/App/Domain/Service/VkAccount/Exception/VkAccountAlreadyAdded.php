<?php

declare(strict_types=1);

namespace App\Domain\Service\VkAccount\Exception;

use RuntimeException;

class VkAccountAlreadyAdded extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Vk account already added.');
    }
}
