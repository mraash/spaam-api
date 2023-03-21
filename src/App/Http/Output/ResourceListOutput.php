<?php

declare(strict_types=1);

namespace App\Http\Output;

use SymfonyExtension\Domain\Entity\ResourceEntityInterface;
use SymfonyExtension\Http\Resource\ResourceCollection;

class ResourceListOutput extends AbstractSuccessOutput
{
    private ResourceCollection $collection;

    /**
     * @param ResourceEntityInterface[] $entityList
     */
    public function __construct(array $entityList)
    {
        $resourceList = [];

        foreach ($entityList as $entity) {
            array_push($resourceList, $entity->toResource());
        }

        $this->collection = new ResourceCollection($resourceList);
    }

    protected function data(): array
    {
        return $this->collection->toArray();
    }
}
