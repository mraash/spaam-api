<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http\SpamPanel;

use App\Domain\Entity\SpamPanel;

class CreateSpamPanelTest extends SpamPanelTestCase
{
    private static function getMethod(): string
    {
        return 'POST';
    }

    private static function getUri(): string
    {
        return '/v1/spam-panels';
    }

    public function test_successful(): void
    {
        $user = $this->createAndLoginUser();
        $vkAccount = $this->createVkAccount($user);

        $this->client->request(self::getMethod(), self::getUri(), content: $this->toJson([
            'senderId' => $vkAccount->getId(),
            'recipient' => 'abc',
            'texts' => [
                'text-1',
                'text, text, 2'
            ],
            'timers' => [
                [
                    'seconds' => 60,
                    'repeat' => 3,
                ]
            ],
        ]));

        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);
        $dbSpamPanel = $this->repository->findOneBy([]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonResponse($response);
        $this->assertJsonMatchesPayloadSchema($responseData, self::getResourceSchema());
        $this->assertInstanceOf(SpamPanel::class, $dbSpamPanel);
    }

    public function test_unauthorized(): void
    {
        $this->makeBasicAccessDeniedTest(self::getMethod(), self::getUri());
    }
}
