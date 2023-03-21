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

    /**
     * @return mixed[]
     */
    private static function getResponseSchema(): array
    {
        return [
            'type' => 'object',
            'required' => ['id', 'vkId'],
            'properties' => [
                'id' => ['type' => 'integer'],
                'vkId' => ['type' => 'integer'],
            ],
        ];
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
        $this->assertJsonMatchesSuccessSchema($responseData, self::getResponseSchema());
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
