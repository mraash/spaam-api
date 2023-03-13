<?php

declare(strict_types=1);

namespace App\Http\Response\SpamPanel;

use App\Domain\Entity\SpamPanel;
use App\Domain\Entity\VkAccount;

class SpamPanelResource
{
    public int $id;

    /** @var mixed[] */
    public array $sender;

    public string $recipient;

    /** @var mixed[] */
    public array $texts;

    /** @var mixed[] */
    public array $timers;

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
