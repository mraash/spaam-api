<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

use App\Domain\Entity\VkAccount;
use Tests\App\Functional\Http\AppWebTestCase;

abstract class VkAccountTestCase extends AppWebTestCase
{
    use CreatesVkAccountTrait;

    protected function getEntityClass(): string
    {
        return VkAccount::class;
    }
}
