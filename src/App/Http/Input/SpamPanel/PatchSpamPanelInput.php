<?php

declare(strict_types=1);

namespace App\Http\Input\SpamPanel;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Input\Input\AbstractJsonBodyInput;

class PatchSpamPanelInput extends AbstractJsonBodyInput
{
    // TODO: Merge PATCH constraints with POST and PUT constraints
    protected static function fields(): array
    {
        return [
            'senderId' => new Optional([
                new NotBlank(),
                new Type('integer'),
            ]),
            'recipient' => new Optional([
                new NotBlank(),
                new Type('string'),
            ]),
            'texts' => new Optional([
                new NotBlank(),
                new Type('array'),
                new All([
                    new Type('string'),
                ]),
            ]),
            'timers' => new Optional([
                new NotBlank(),
                new Type('array'),
                new All(new Collection([
                    'seconds' => [
                        new NotBlank(),
                        new Type('integer'),
                    ],
                    'repeat' => [
                        new NotBlank(),
                        new Type('integer'),
                    ],
                ])),
            ]),
        ];
    }

    public function getSenderId(): int|null
    {
        /** @var int|null */
        return $this->getParamOrNull('senderId');
    }

    public function getRecipient(): string|null
    {
        /** @var string|null */
        return $this->getParamOrNull('recipient');
    }

    /**
     * @return string[]|null
     */
    public function getTexts(): array|null
    {
        /** @var string[]|null */
        return $this->getParamOrNull('texts');
    }

    /**
     * @return array<array<string,int>>|null
     */
    public function getTimers(): array|null
    {
        /** @var array<array<string,int>>|null */
        return $this->getParamOrNull('timers');
    }
}
