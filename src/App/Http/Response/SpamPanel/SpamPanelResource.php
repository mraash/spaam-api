<?php

declare(strict_types=1);

namespace App\Http\Response\SpamPanel;

use App\Domain\Entity\SpamPanel;
use App\Domain\Entity\VkAccount;

class SpamPanelResource
{
    public readonly int $id;

    /** @var mixed[] */
    public readonly array $sender;

    public readonly string $recipient;

    /** @var mixed[] */
    public readonly array $texts;

    /** @var mixed[] */
    public readonly array $timers;

    public function __construct(SpamPanel $spamPanel)
    {
        $this->id = $spamPanel->getId();
        $this->sender = [
            'id' => $spamPanel->getSender()->getId(),
            'vkId' => $spamPanel->getSender()->getVkId(),
        ];
        $this->recipient = $spamPanel->getRecipient();
        $this->texts = $spamPanel->getTexts();
        $this->timers = $spamPanel->getTimers();
    }
}
