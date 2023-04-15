<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

class GetSingleVkAccountTest extends VkAccountTestCase
{
    private static function getMethod(): string
    {
        return 'GET';
    }

    private static function getUri(int $id): string
    {
        return "/v1/vk-accounts/$id";
    }

    public function test_successful(): void
    {
        $user = $this->createAndLoginUser();
        $vkAccount = $this->createVkAccount($user);

        $this->client->request(self::getMethod(), self::getUri($vkAccount->getId()));
        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponse($response);
        $this->assertJsonMatchesPayloadSchema($responseData, self::getResourceSchema());
    }

    public function test_unauthorized(): void
    {
        $this->makeBasicAccessDeniedTest(self::getMethod(), self::getUri(1));
    }

    public function test_not_found(): void
    {
        $this->createAndLoginUser();

        $this->client->request(self::getMethod(), self::getUri(666));
        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);

        $this->assertResponseStatusCodeSame(404);
        $this->assertJsonResponse($response);
        $this->assertJsonErrorSchema($responseData);
    }

    public function test_another_owner(): void
    {
        $realOwner = $this->createUser('real-owner@test.com');
        $vkAccount = $this->createVkAccount($realOwner);

        $this->createAndLoginUser('test@test.com');

        $this->client->request(self::getMethod(), self::getUri($vkAccount->getId()));
        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);

        $this->assertResponseStatusCodeSame(404);
        $this->assertJsonResponse($response);
        $this->assertJsonErrorSchema($responseData);
    }
}
