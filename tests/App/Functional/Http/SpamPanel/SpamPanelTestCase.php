<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\SpamPanel;

use App\Domain\Entity\SpamPanel;
use Tests\App\Functional\Http\AppWebTestCase;
use Tests\App\Functional\Http\VkAccount\CreatesVkAccountTrait;

abstract class SpamPanelTestCase extends AppWebTestCase
{
    use CreatesVkAccountTrait;

    protected static function getEntityClass(): string
    {
        return SpamPanel::class;
    }

    /**
     * @return mixed[]
     */
    protected static function getResourceSchema(): array
    {
        return [
            'type' => 'object',
            'required' => ['id', 'sender', 'recipient', 'texts', 'timers'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'sender' => [
                    'type' => 'object',
                    'required' => ['id', 'vk'],
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'vk' => [
                            'type' => 'object',
                            'required' => ['id', 'slug', 'fullName'],
                            'properties' => [
                                'id' => ['type' => 'number'],
                                'slug' => ['type' => 'string'],
                                'fullName' => ['type' => 'string'],
                            ],
                        ],
                    ],
                ],
                'recipient' => ['type' => 'string'],
                'texts' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                ],
                'timers' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['seconds', 'repeat'],
                        'properties' => [
                            'seconds' => ['type' => 'integer'],
                            'repeat' => ['type' => 'integer'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
