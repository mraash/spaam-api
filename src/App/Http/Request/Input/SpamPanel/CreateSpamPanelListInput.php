<?php

declare(strict_types=1);

namespace App\Http\Request\Input\SpamPanel;

use App\Http\Request\InputDto\SpamPanel\SpamPanelInputDto;
use App\Http\Request\InputDto\SpamPanel\TimerInputDto;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Input\Input\AbstractJsonBodyInput;

class CreateSpamPanelListInput extends AbstractJsonBodyInput
{
    /** @var SpamPanelInputDto[] */
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
                ]),
            ]),
        ];
    }

    /**
     * @return SpamPanelInputDto[]
     */
    public function getItems(): array
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
        /** @var array<array<mixed>> */
        $items = $this->getParam('items');

        $this->items = [];

        foreach ($items as $item) {
            /** @var int */ $senderId = $item['senderId'];
            /** @var string */ $recipient = $item['recipient'];
            /** @var string[] */ $texts = $item['texts'];
            /** @var array<array<string,int>> */ $rawTimers = $item['timers'];

            /** @var TimerInputDto[] */ $timers = [];

            foreach ($rawTimers as $rawTimer) {
                $timers[] = new TimerInputDto(
                    /** @var int */ $rawTimer['seconds'],
                    /** @var int */ $rawTimer['repeat'],
                );
            }

            $this->items[] = new SpamPanelInputDto($senderId, $recipient, $texts, $timers);
        }
    }
}
