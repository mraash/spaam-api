<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Resource;

class ResourceCollection
{
    /**
     * @param AbstractResource[] $resourceList
     */
    public function __construct(
        private array $resourceList,
    ) {
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        $result = [];

        foreach ($this->resourceList as $resource) {
            array_push($result, $resource->toArray());
        }

        return $result;
    }
}
