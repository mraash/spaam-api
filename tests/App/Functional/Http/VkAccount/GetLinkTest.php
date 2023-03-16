<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

class GetLinkTest extends AbstractVkAccountTest
{
    private static function getMethod(): string
    {
        return 'GET';
    }

    private static function getUri(): string
    {
        return '/v1/vk-accounts/link';
    }

    public function test_successful(): void
    {
        $this->createAndLoginUser();
        $this->client->request(self::getMethod(), self::getUri());

        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponse($response);
        $this->assertJsonDocumentMatchesSchema($responseData, [
            'type' => 'object',
            'required' => ['link'],
            'properties' => [
                'link' => ['type' => 'string'],
            ]
        ]);
    }

    public function test_unauthorized(): void
    {
        $this->makeBasicAccessDeniedTest(self::getMethod(), self::getUri());
    }
}
