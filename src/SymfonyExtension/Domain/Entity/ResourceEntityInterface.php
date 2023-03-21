<?php

declare(strict_types=1);

namespace SymfonyExtension\Domain\Entity;

use SymfonyExtension\Http\Resource\AbstractResource;

interface ResourceEntityInterface
{
    public function toResource(): AbstractResource;
}
