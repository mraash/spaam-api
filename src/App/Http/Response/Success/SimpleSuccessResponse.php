<?php

declare(strict_types=1);

namespace App\Http\Response\Success;

class SimpleSuccessResponse
{
    public readonly bool $sucess;

    public function __construct()
    {
        $this->sucess = true;
    }
}
