<?php

declare(strict_types=1);

namespace App\Domain\Service\SpamPanel\Exception;

use RuntimeException;

class SpamPanelNotFoundException extends RuntimeException
{
    public function __construct(string $message = null)
    {
        $message = $message ?? 'Spam panel not found.';

        parent::__construct($message);
    }

    public static function fromIdMessage(int $id): self
    {
        return new self("Spam panel with id \"$id\" not found.");
    }
}
