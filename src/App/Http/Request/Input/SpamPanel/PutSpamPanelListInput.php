<?php

declare(strict_types=1);

namespace App\Http\Request\Input\SpamPanel;

use App\Http\Request\InputDto\SpamPanel\SpamPanelIdInputDto;
use App\Http\Request\InputDto\SpamPanel\SpamPanelInputDto;
use App\Http\Request\InputDto\SpamPanel\TimerInputDto;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Input\Input\AbstractJsonBodyInput;

class PutSpamPanelListInput extends AbstractJsonBodyInput
{
    // todo: Use InputDto in all Inputs where its needed
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
                new All([
                    new NotNull(),
                    new Type('array'),
                    new Collection([
                        'id' => new Required([
                            new NotNull(),
                            new Type('integer'),
                        ]),
                        'item' => new Required([
                            new NotNull(),
                            new Type('array'),
                            new Collection([
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
                            ]),
                        ]),
                    ]),
                ]),
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
        /** @var array<array<string,mixed>> */
        $itemsParam = $this->getParam('items');

        foreach ($itemsParam as $itemAndId) {
            /** @var int */ $id = $itemAndId['id'];
            /** @var array<string,mixed> */ $item = $itemAndId['item'];

            /** @var int */ $senderId = $item['senderId'];
            /** @var string */ $recipient = $item['recipient'];
            /** @var string[] */ $texts = $item['texts'];
            /** @var array<array<string,int|null>> */ $rawTimers = $item['timers'];

            /** @var TimerInputDto[] */ $timers = [];

            foreach ($rawTimers as $timerItem) {
                $timers[] = new TimerInputDto(
                    /** @var int */                    $timerItem['seconds'],
                    /** @var int */ $timerItem['repeat']
                );
            }

            $spamPanel = new SpamPanelInputDto($senderId, $recipient, $texts, $timers);

            $this->items[] = new SpamPanelIdInputDto($id, $spamPanel);
        }
    }
}
