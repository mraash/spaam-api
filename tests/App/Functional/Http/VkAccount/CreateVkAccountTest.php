<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

use App\Domain\Entity\VkAccount;

class CreateVkAccountTest extends VkAccountTestCase
{
    private static function getMethod(): string
    {
        return 'GET';
    }

    private static function getUri(): string
    {
        return '/v1/vk-accounts/create';
    }

    public function test_successful(): void
    {
        $this->createAndLoginUser();

        $this->client->request(self::getMethod(), self::getUri(), parameters: [
            'access_token' => 'abc',
            'user_id' => '123',
            'expires_in' => '0',
        ]);

        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);
        $dbVkAccount = $this->repository->findOneBy(['vkAccessToken' => 'abc']);

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponse($response);
        $this->assertJsonMatchesPayloadSchema($responseData, self::getResourceSchema());
        $this->assertInstanceOf(VkAccount::class, $dbVkAccount);
    }

    public function test_unauthorized(): void
    {
        $this->makeBasicAccessDeniedTest(self::getMethod(), self::getUri());
    }
}
