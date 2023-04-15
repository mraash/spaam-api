<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

use App\Domain\Entity\VkAccount;
use Tests\App\Functional\Http\AppWebTestCase;

abstract class VkAccountTestCase extends AppWebTestCase
{
    use CreatesVkAccountTrait;

    protected static function getEntityClass(): string
    {
        return VkAccount::class;
    }
    /**
     * @return mixed[]
     */
    protected static function getResourceSchema(): array
    {
        return [
            'type' => 'object',
            'required' => ['id', 'vk'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'vk' => [
                    'type' => 'object',
                    'required' => ['id', 'slug', 'fullName'],
                    'properties' => [
                        'id' => ['type' => 'integer'],
                        'slug' => ['type' => 'string'],
                        'fullName' => ['type' => 'string'],
                    ],
                ],
            ],
        ];
    }
}
