<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\SpamPanel;

use App\Domain\Entity\SpamPanel;
use Tests\App\Functional\Http\AppWebTestCase;
use Tests\App\Functional\Http\VkAccount\CreatesVkAccountTrait;

abstract class SpamPanelTestCase extends AppWebTestCase
{
    use CreatesVkAccountTrait;

    protected function getEntityClass(): string
    {
        return SpamPanel::class;
    }
}
