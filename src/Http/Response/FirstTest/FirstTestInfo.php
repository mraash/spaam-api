<?php

declare(strict_types=1);

namespace App\Http\Response\FirstTest;

use App\Domain\Entity\FirstTest;

class FirstTestInfo
{
    public readonly int $id;
    public readonly string $property_str;
    public readonly int $property_int;
    public readonly bool $property_bool;

    public function __construct(FirstTest $firstTest)
    {
        $this->id = $firstTest->getId();
        $this->property_str = $firstTest->getPropertyStr();
        $this->property_int = $firstTest->getPropertyInt();
        $this->property_bool = $firstTest->isPropertyBool();
    }
}
