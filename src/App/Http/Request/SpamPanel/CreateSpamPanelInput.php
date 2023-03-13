<?php

declare(strict_types=1);

namespace App\Http\Request\SpamPanel;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Attribute\Input\AsJsonBodyInput;

#[AsJsonBodyInput]
class CreateSpamPanelInput
{
    #[NotBlank]
    #[Type('integer')]
    public mixed $senderId;

    #[NotBlank]
    #[Type('string')]
    public mixed $recipient;

    #[NotBlank]
    #[Type('array')]
    #[All([
        new Type('string'),
    ])]
    public mixed $texts;

    /** @var mixed|array */
    #[NotBlank]
    #[Type('array')]
    #[All(new Collection([
        'seconds' => [
            new NotBlank(),
            new Type('integer'),
        ],
        'repeat' => [
            new NotBlank(),
            new Type('integer'),
        ],
    ]))]
    public mixed $timers;

    public function __construct(mixed $senderId, mixed $recipient, mixed $texts, mixed $timers)
    {
        $this->senderId = $senderId;
        $this->recipient = $recipient;
        $this->texts = $texts;
        $this->timers = $timers;
    }

    public function getSenderId(): int
    {
        /** @var int */
        return $this->senderId;
    }

    public function getRecipient(): string
    {
        /** @var string */
        return $this->recipient;
    }

    /**
     * @return string[]
     */
    public function getTexts(): array
    {
        /** @var string[] */
        return $this->texts;
    }

    /**
     * @return Timer[]
     */
    public function getTimers(): array
    {
        /** @var Timer[] */
        return $this->timers;
    }
}
