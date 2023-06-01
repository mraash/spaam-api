<?php

declare(strict_types=1);

namespace App\Domain\Service\Vk\Exception;

use RuntimeException;

class UserIsBlockedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('User is blocked.');
    }
}
