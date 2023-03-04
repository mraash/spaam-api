<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

use App\Domain\Entity\VkAccount;
use Tests\App\Functional\Http\AbstractWebTestCase;

class CreateVkAccountTest extends AbstractWebTestCase
{
    private const URI = '/v1/vk-accounts/create';
    private const METHOD = 'GET';

    public function getEntityClass(): string
    {
        return VkAccount::class;
    }

    public function test_successful(): void
    {
        $this->loginUser();

        $this->client->request(self::METHOD, self::URI, parameters: [
            'access_token' => 'abc',
            'user_id' => '123'
        ]);

        $this->client->getResponse();

        $vkAccount = $this->repository->findOneBy(['vkAccessToken' => 'abc']);

        $this->assertResponseIsSuccessful();
        $this->assertInstanceOf(VkAccount::class, $vkAccount);
    }
}
