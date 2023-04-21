<?php

declare(strict_types=1);

namespace App\Http\Input\SpamPanel;

use App\Http\InputDto\SpamPanel\SpamPanelIdInputDto;
use App\Http\InputDto\SpamPanel\SpamPanelInputDto;
use App\Http\InputDto\SpamPanel\TimerInputDto;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Input\Input\AbstractJsonBodyInput;

class PutSpamPanelListInput extends AbstractJsonBodyInput
{
    // TODO: Use InputDto in all Inputs where its needed
    /**
     * @var SpamPanelIdInputDto[]
     */
    private array $items;

    protected static function fields(): array
    {
        return [
            'items' => new Required([
                new NotNull(),
                new Type('array'),
                new All(
                    new Collection([
                        'id' => new Required([
                            new NotNull(),
                            new Type(['integer']),
                        ]),
                        'item' => new Required([
                            new NotNull(),
                            new Type('array'),
                            new Collection([
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
                            ]),
                        ])
                    ])
                )
            ]),
        ];
    }

    /**
     * @return SpamPanelIdInputDto[]
     */
    public function getSpamPanelList(): array
    {
        if (!isset($this->items)) {
            $this->createItems();
        }

        return $this->items;
    }

    /**
     * Set $this->items
     */
    private function createItems(): void
    {
        /** @var array<mixed> */
        $itemsParam = $this->getParam('items');

        foreach ($itemsParam as $itemAndId) {
            /** @var int|null */
            $id = $itemAndId['id'] ?? null;

            /** @var int */
            $senderId = $itemAndId['item']['senderId'];

            /** @var string */
            $recipient = $itemAndId['item']['recipient'];

            /** @var string[] */
            $texts = $itemAndId['item']['texts'];

            /** @var TimerInputDto[] */
            $timers = [];

            foreach ($itemAndId['item']['timers'] as $timerItem) {
                /** @var int */
                $seconds = $timerItem['seconds'];

                /** @var int */
                $repeat = $timerItem['repeat'];

                $timers[] = new TimerInputDto($seconds, $repeat);
            }

            $spamPanel = new SpamPanelInputDto(
                $senderId,
                $recipient,
                $texts,
                $timers,
            );

            $this->items[] = new SpamPanelIdInputDto(
                $id,
                $spamPanel
            );
        }
    }
}
