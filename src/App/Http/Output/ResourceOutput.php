<?php

declare(strict_types=1);

namespace App\Http\Output;

use SymfonyExtension\Domain\Entity\ResourceEntityInterface;
use SymfonyExtension\Http\Resource\AbstractResource;

class ResourceOutput extends AbstractSuccessOutput
{
    private AbstractResource $resource;

    public function __construct(ResourceEntityInterface $entity)
    {
        $this->resource = $entity->toResource();
    }

    protected function payload(): array
    {
        return $this->resource->toArray();
    }
}
