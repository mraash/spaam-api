<?php

declare(strict_types=1);

namespace App\Http\Output;

use SymfonyExtension\Domain\Entity\ResourceEntityInterface;
use SymfonyExtension\Http\Resource\AbstractResource;
use SymfonyExtension\Http\Resource\ResourceCollection;

class ResourceOutput extends AbstractSuccessOutput
{
    private AbstractResource $resource;

    public function __construct(ResourceEntityInterface $entity) {
        $this->resource = $entity->toResource();
    }

    protected function data(): array
    {
        return $this->resource->toArray();
    }
}