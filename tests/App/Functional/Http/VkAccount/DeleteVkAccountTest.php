<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

class DeleteVkAccountTest extends VkAccountTestCase
{
    private static function getMethod(): string
    {
        return 'DELETE';
    }

    private static function getUri(int $id): string
    {
        return "/v1/vk-accounts/$id";
    }

    public function test_successful(): void
    {
        $user = $this->createAndLoginUser();
        $vkAccount = $this->createVkAccount($user);
        $id = $vkAccount->getId();

        $this->client->request(self::getMethod(), self::getUri($id));

        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);
        $dbVkAccount = $this->repository->find($id);

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponse($response);
        $this->assertJsonSuccessSchema($responseData);
        $this->assertNull($dbVkAccount);
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

    public function test_wrong_owner(): void
    {
        $realOwner = $this->createUser('tester@test.com');
        $vkAccount = $this->createVkAccount($realOwner);
        $id = $vkAccount->getId();

        $this->createAndLoginUser('admin@test.com');

        $this->client->request(self::getMethod(), self::getUri($id));

        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);

        $this->assertResponseStatusCodeSame(404);
        $this->assertJsonResponse($response);
        $this->assertJsonErrorSchema($responseData);
    }
}
