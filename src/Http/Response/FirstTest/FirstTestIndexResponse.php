<?php

declare(strict_types=1);

namespace App\Http\Response\FirstTest;

use App\Domain\Entity\FirstTest;

class FirstTestIndexResponse
{
    /** @var FirstTestInfo[] */
    public readonly array $items;
    public readonly int $count;

    /**
     * @param FirstTest[] $firstTests
     */
    public function __construct(array $firstTests)
    {
        $items = [];

        foreach ($firstTests as $firstTest) {
            array_push($items, new FirstTestInfo($firstTest));
        }

        $this->items = $items;
        $this->count = count($items);
    }
}
