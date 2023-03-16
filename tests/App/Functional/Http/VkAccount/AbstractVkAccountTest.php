<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

use App\Domain\Entity\VkAccount;
use Tests\App\Functional\Http\AbstractWebTestCase;

abstract class AbstractVkAccountTest extends AbstractWebTestCase
{
    use CreatesVkAccount;

    protected function getEntityClass(): string
    {
        return VkAccount::class;
    }
}
