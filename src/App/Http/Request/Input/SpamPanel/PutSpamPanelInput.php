<?php

declare(strict_types=1);

namespace App\Http\Request\Input\SpamPanel;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Input\Input\AbstractJsonBodyInput;

class PutSpamPanelInput extends AbstractJsonBodyInput
{
    protected static function fields(): array
    {
        return [
            'senderId' => new Required([
                new Type(['integer', 'null']),
            ]),
            'recipient' => new Required([
                new NotNull(),
                new Type('string'),
            ]),
            'texts' => new Required([
                new NotNull(),
                new Type('array'),
                new All([
                    new Type('string'),
                ]),
            ]),
            'timers' => new Required([
                new NotNull(),
                new Type('array'),
                new All(new Collection([
                    'seconds' => [
                        new Type(['integer', 'null']),
                    ],
                    'repeat' => [
                        new Type(['integer', 'null']),
                    ],
                ])),
            ]),
        ];
    }

    public function getSenderId(): int|null
    {
        /** @var int|null */
        return $this->getParam('senderId');
    }

    public function getRecipient(): string
    {
        /** @var string */
        return $this->getParam('recipient');
    }

    /**
     * @return string[]
     */
    public function getTexts(): array
    {
        /** @var string[] */
        return $this->getParam('texts');
    }

    /**
     * @return array<array<string,int|null>>
     */
    public function getTimers(): array
    {
        /** @var array<array<string,int|null>> */
        return $this->getParam('timers');
    }
}
