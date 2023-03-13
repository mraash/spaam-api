<?php

declare(strict_types=1);

namespace App\Http\Response\SpamPanel;

use App\Domain\Entity\SpamPanel;

class SpamPanelIndexResponse
{
    /** @var SpamPanelResource */
    public array $spamPanels;

    /**
     * @param SpamPanel[] $spamPanels
     */
    public function __construct(array $spamPanels)
    {
        $this->spamPanels = [];

        foreach ($spamPanels as $spamPanel) {
            array_push($this->spamPanels, new SpamPanelResource($spamPanel));
        }
    }
}
