<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

use Tests\App\Functional\Http\AbstractWebTestCase;

class GetLinkTest extends AbstractWebTestCase
{
    private const METHOD = 'GET';
    private const URI = '/v1/vk-accounts/link';

    public function test_successful(): void
    {
        $this->loginUser();
        $this->client->request(self::METHOD, self::URI);

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
        $this->makeBasicAccessDeniedTest(self::METHOD, self::URI);
    }
}
