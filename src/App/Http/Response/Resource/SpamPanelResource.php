<?php

declare(strict_types=1);

namespace App\Http\Response\Resource;

use App\Domain\Entity\SpamPanel;
use SymfonyExtension\Http\Resource\AbstractResource;

class SpamPanelResource extends AbstractResource
{
    public function __construct(
        private SpamPanel $spamPanel,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->spamPanel->getId(),
            'sender' => $this->spamPanel->getSender()?->toResource()->toArray(),
            'recipient' => $this->spamPanel->getRecipient(),
            'texts' => $this->spamPanel->getTexts(),
            'timers' => $this->spamPanel->getTimers(),
        ];
    }
}
