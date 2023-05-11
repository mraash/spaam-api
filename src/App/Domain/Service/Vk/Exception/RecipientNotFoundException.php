<?php

declare(strict_types=1);

namespace App\Domain\Service\Vk\Exception;

use RuntimeException;

class RecipientNotFoundException extends RuntimeException
{
    public function __construct(int|string $id)
    {
        parent::__construct(sprintf('Recipient with id "%s" not found.', (string) $id));
    }
}
