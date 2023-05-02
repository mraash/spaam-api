<?php

declare(strict_types=1);

namespace App\Http\Request\InputDto\SpamPanel;

class TimerInputDto
{
    public function __construct(
        public readonly int $seconds,
        public readonly int $repeat,
    ) {
    }
}
