<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

class GetIndexVkAccountTest extends VkAccountTestCase
{
    private static function getMethod(): string
    {
        return 'GET';
    }

    private static function getUri(): string
    {
        return "/v1/vk-accounts";
    }

    /**
     * @return mixed[]
     */
    private static function getResponseSchema(): array
    {
        return [
            'type' => 'object',
            'required' => ['items'],
            'properties' => [
                'items' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['id', 'vkId'],
                        'properties' => [
                            'id' => ['type' => 'integer'],
                            'vkId' => ['type' => 'integer'],
                        ],
                    ]
                ],
            ]
        ];
    }

    public function test_successful(): void
    {
        $user = $this->createAndLoginUser();
        $this->createVkAccount($user);

        $this->client->request(self::getMethod(), self::getUri());
        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponse($response);
        $this->assertJsonDocumentMatchesSchema($responseData, self::getResponseSchema());
    }

    public function test_unauthorized(): void
    {
        $this->makeBasicAccessDeniedTest(self::getMethod(), self::getUri(1));
    }

    public function test_another_owner(): void
    {
        $realOwner = $this->createUser('real-owner@test.com');
        $this->createVkAccount($realOwner);

        $this->createAndLoginUser('test@test.com');

        $this->client->request(self::getMethod(), self::getUri());
        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponse($response);
        $this->assertJsonDocumentMatchesSchema($responseData, self::getResponseSchema());
        $this->assertCount(0, $responseData['items']);
    }
}
