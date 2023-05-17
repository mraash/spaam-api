<?php

declare(strict_types=1);

namespace App\Http\Request\Input\SpamPanel;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Input\Input\AbstractJsonBodyInput;

class PatchSpamPanelInput extends AbstractJsonBodyInput
{
    // todo: Merge PATCH constraints with POST and PUT constraints
    protected static function fields(): array
    {
        return [
            'senderId' => new Optional([
                new Type(['integer', 'null']),
            ]),
            'recipient' => new Optional([
                new NotNull(),
                new Type('string'),
            ]),
            'texts' => new Optional([
                new NotNull(),
                new Type('array'),
                new All([
                    new Type('string'),
                ]),
            ]),
            'timers' => new Optional([
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

    public function hasSenderId(): bool
    {
        return $this->hasParam('senderId');
    }

    public function getSenderId(): int|null
    {
        /** @var int|null */
        return $this->getParamOrNull('senderId');
    }

    public function getRecipientOrNull(): string|null
    {
        /** @var string|null */
        return $this->getParamOrNull('recipient');
    }

    /**
     * @return string[]|null
     */
    public function getTextsOrNull(): array|null
    {
        /** @var string[]|null */
        return $this->getParamOrNull('texts');
    }

    /**
     * @return array<array<string,int|null>>|null
     */
    public function getTimersOrNull(): array|null
    {
        /** @var array<array<string,int|null>>|null */
        return $this->getParamOrNull('timers');
    }
}
