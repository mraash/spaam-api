<?php

declare(strict_types=1);

namespace App\Domain\Exception\FirstTest;

use Exception;

class FirstTestNotFoundException extends Exception
{
    public function __construct(
        private int $id
    ) {
        parent::__construct("FirstTest with id '$id' not found.");
    }

    public function getId(): int
    {
        return $this->id;
    }
}
