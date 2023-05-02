<?php

declare(strict_types=1);

namespace App\Http\Request\InputDto\SpamPanel;

/**
 * Panel item that has optional id property.
 */
class SpamPanelIdInputDto
{
    public function __construct(
        public readonly int $id,
        public readonly SpamPanelInputDto $item,
    ) {
    }
}
