<?php

declare(strict_types=1);

namespace App\Domain\Service\Vk\Exception;

use RuntimeException;

class CaptchaException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Captcha needed.');
    }
}
