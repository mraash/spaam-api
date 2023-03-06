<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\VkAccount;

class DeleteVkAccountTest extends AbstractVkAccountTest
{
    public function test_successful(): void
    {
        $user = $this->createAndLoginUser();
        $vkAccount = $this->createVkAccount($user);
        $id = $vkAccount->getId();

        $this->getClient()->request('DELETE', "/v1/vk-accounts/$id");

        $response = $this->getClient()->getResponse();
        $dbVkAccount = $this->getRepository()->find($id);

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponse($response);
        $this->assertNull($dbVkAccount);
    }

    public function test_unauthorized(): void
    {
        $this->makeBasicAccessDeniedTest('DELETE', '/v1/vk-accounts/1');
    }

    public function test_not_found(): void
    {
        $this->createAndLoginUser();

        $this->getClient()->request('DELETE', '/v1/vk-accounts/666');

        $response = $this->getClient()->getResponse();

        $this->assertResponseStatusCodeSame(404);
        $this->assertJsonResponse($response);
    }

    public function test_wrong_owner(): void
    {
        $realOwner = $this->createUser('tester@test.com');
        $vkAccount = $this->createVkAccount($realOwner);
        $id = $vkAccount->getId();

        $this->createAndLoginUser('admin@test.com');

        $this->getClient()->request('DELETE', "/v1/vk-accounts/$id");

        $response = $this->getClient()->getResponse();

        $this->assertResponseStatusCodeSame(404);
        $this->assertJsonResponse($response);
    }
}
