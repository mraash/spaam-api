<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\SpamPanel;

use App\Domain\Entity\SpamPanel;
use Tests\App\Functional\Http\AbstractWebTestCase;
use Tests\App\Functional\Http\VkAccount\CreatesVkAccount;

abstract class AbstractSpamPanelTest extends AbstractWebTestCase
{
    use CreatesVkAccount;

    protected function getEntityClass(): string
    {
        return SpamPanel::class;
    }
}
