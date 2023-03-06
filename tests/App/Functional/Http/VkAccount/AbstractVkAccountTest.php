<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

use App\Domain\Entity\User;
use App\Domain\Entity\VkAccount;
use Tests\App\Functional\Http\AbstractWebTestCase;

abstract class AbstractVkAccountTest extends AbstractWebTestCase
{
    protected function getEntityClass(): ?string
    {
        return VkAccount::class;
    }

    protected function createVkAccount(User $owner, string $vkAccessToken = null, int $vkId = null): VkAccount
    {
        $vkAccessToken = $vkAccessToken ?? 'abc';
        $vkId = $vkId ?? 123;

        $vkAccount = new VkAccount();

        $vkAccount
            ->setOwner($owner)
            ->setVkAccessToken($vkAccessToken)
            ->setVkId($vkId)
        ;

        $this->getEntityManager()->persist($vkAccount);
        $this->getEntityManager()->flush();

        return $vkAccount;
    }
}
