<?php

declare(strict_types=1);

namespace App\Http\Response\SpamPanel;

use App\Domain\Entity\SpamPanel;

class SpamPanelIndexResponse
{
    /** @var SpamPanelResource[] */
    public readonly array $items;

    /**
     * @param SpamPanel[] $spamPanels
     */
    public function __construct(array $spamPanels)
    {
        $resourceList = [];

        foreach ($spamPanels as $spamPanel) {
            array_push($resourceList, new SpamPanelResource($spamPanel));
        }

        $this->items = $resourceList;
    }
}
