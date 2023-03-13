<?php

declare(strict_types=1);

namespace App\Domain\Service\SpamPanel\Exception;

use RuntimeException;

class SpamPanelNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Spam panel not found');
    }
}
