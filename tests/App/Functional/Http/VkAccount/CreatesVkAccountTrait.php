<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

use App\Domain\Entity\User;
use App\Domain\Entity\VkAccount;

trait CreatesVkAccountTrait
{
    protected function createVkAccount(User $owner, string $vkAccessToken = null, int $vkId = null): VkAccount
    {
        $vkAccessToken = $vkAccessToken ?? 'abc';
        $vkId = $vkId ?? 123;

        $vkAccount = new VkAccount();

        $vkAccount
            ->setOwner($owner)
            ->setVkAccessToken($vkAccessToken)
            ->setVkId($vkId)
            ->setVkSlug('slug')
            ->setVkFullName('full name')
        ;

        $this->em->persist($vkAccount);
        $this->em->flush();

        return $vkAccount;
    }
}
