<?php

declare(strict_types=1);

namespace App\Domain\Service\VkAccount\Exception;

use RuntimeException;

class VkAccountNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Vk account not found.');
    }
}
