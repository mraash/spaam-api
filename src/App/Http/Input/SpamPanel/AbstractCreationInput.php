<?php

declare(strict_types=1);

namespace App\Http\Input\SpamPanel;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Input\Input\AbstractJsonBodyInput;

abstract class AbstractCreationInput extends AbstractJsonBodyInput
{
    protected static function fields(): array
    {
        return [
            'senderId' => new Required([
                new NotBlank(),
                new Type('integer'),
            ]),
            'recipient' => new Required([
                new NotBlank(),
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

    /**
     * @return string[]
     */
    public function getTexts(): array
    {
        /** @var string[] */
        return $this->getParam('texts');
    }

    /**
     * @return array<array<string,int>>
     */
    public function getTimers(): array
    {
        /** @var array<array<string,int>> */
        return $this->getParam('timers');
    }
}
