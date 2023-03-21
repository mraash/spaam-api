<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

class GetLinkTest extends VkAccountTestCase
{
    private static function getMethod(): string
    {
        return 'GET';
    }

    private static function getUri(): string
    {
        return '/v1/vk-accounts/link';
    }

    /**
     * @return mixed[]
     */
    private static function getResponseSchema(): array
    {
        return [
            'type' => 'object',
            'required' => ['link'],
            'properties' => [
                'link' => ['type' => 'string'],
            ]
        ];
    }

    public function test_successful(): void
    {
        $this->createAndLoginUser();
        $this->client->request(self::getMethod(), self::getUri());

        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponse($response);
        $this->assertJsonMatchesSuccessSchema($responseData, self::getResponseSchema());
    }

    public function test_unauthorized(): void
    {
        $this->makeBasicAccessDeniedTest(self::getMethod(), self::getUri());
    }
}
