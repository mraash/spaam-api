<?php

declare(strict_types=1);

namespace App\Domain\Service\SpamPanel\Exception;

use RuntimeException;

class EmptyTextListException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Spam panel has no text.');
    }
}
