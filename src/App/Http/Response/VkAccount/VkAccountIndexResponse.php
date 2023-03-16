<?php

declare(strict_types=1);

namespace App\Http\Response\VkAccount;

use App\Domain\Entity\VkAccount;

class VkAccountIndexResponse
{
    /** @var VkAccountResource[] */
    public readonly array $vkAccounts;

    /**
     * @param VkAccount[] $vkAccountList
     */
    public function __construct(array $vkAccountList)
    {
        $recourceList = [];

        foreach ($vkAccountList as $vkAccount) {
            array_push($recourceList, new VkAccountResource($vkAccount));
        }

        $this->vkAccounts = $recourceList;
    }
}
