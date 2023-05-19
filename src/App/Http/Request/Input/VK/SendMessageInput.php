<?php

declare(strict_types=1);

namespace App\Http\Request\Input\VK;

use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Input\Input\AbstractJsonBodyInput;

class SendMessageInput extends AbstractJsonBodyInput
{
    protected static function fields(): array
    {
        return [
            'senderId' => new Required([
                new NotNull(),
                new Type('integer'),
            ]),
            'recipient' => new Required([
                new NotNull(),
                new Type('string'),
            ]),
            'text' => new Required([
                new NotNull(),
                new Type('string'),
            ]),
        ];
    }

    public function getSenderId(): int
    {
        /** @var int */
        return $this->getParam('senderId');
    }

    public function getRecipient(): string
    {
        /** @var string */
        return $this->getParam('recipient');
    }

    public function getText(): string
    {
        /** @var string */
        return $this->getParam('text');
    }
}
