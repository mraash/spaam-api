<?php

declare(strict_types=1);

namespace App\Http\InputDto\SpamPanel;

class SpamPanelInputDto
{
    /**
     * @param string[] $texts,
     * @param TimerInputDto[] $timers
     */
    public function __construct(
        public readonly int $senderId,
        public readonly string $recipient,
        public readonly array $texts,
        public readonly array $timers
    ) {
    }
}
