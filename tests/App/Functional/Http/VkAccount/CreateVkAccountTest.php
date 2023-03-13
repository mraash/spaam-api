<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

use App\Domain\Entity\VkAccount;

class CreateVkAccountTest extends AbstractVkAccountTest
{
    private const URI = '/v1/vk-accounts/create';
    private const METHOD = 'GET';

    public function test_successful(): void
    {
        $this->createAndLoginUser();

        $this->getClient()->request(self::METHOD, self::URI, parameters: [
            'access_token' => 'abc',
            'user_id' => '123'
        ]);

        $response = $this->getClient()->getResponse();
        $dbVkAccount = $this->getRepository()->findOneBy(['vkAccessToken' => 'abc']);

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponse($response);
        $this->assertInstanceOf(VkAccount::class, $dbVkAccount);
    }

    public function test_unauthorized(): void
    {
        $this->makeBasicAccessDeniedTest(self::METHOD, self::URI);
    }
}
