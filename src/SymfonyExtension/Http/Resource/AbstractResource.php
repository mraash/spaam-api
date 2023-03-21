<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Resource;

use SymfonyExtension\Domain\Entity\ResourceEntityInterface;

abstract class AbstractResource
{
    /**
     * @return mixed[]
     */
    abstract public function toArray(): array;
}
