<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Helmich\JsonAssert\JsonAssertions;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class AppWebTestCase extends WebTestCase
{
    use JsonAssertions;

    protected KernelBrowser $client;
    protected EntityManager $em;
    /** @var EntityRepository<object> */
    protected EntityRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $client = self::createClient();

        /** @var EntityManager */
        $em = self::getContainer()->get('doctrine.orm.entity_manager');

        $entityClass = $this->getEntityClass();

        $this->client = $client;
        $this->em = $em;
        $this->repository = $em->getRepository($entityClass);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->em->close();

        unset($this->client);
        unset($this->em);
        unset($this->repository);
    }

    /**
     * Required for the repository.
     *
     * @phpstan-return class-string
     */
    abstract protected function getEntityClass(): string;

    protected function createUser(string $email = null): User
    {
        $email = $email ?? 'test1@test.com';

        $user = new User();

        $user
            ->setEmail($email)
            ->setPassword('123')
        ;

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    protected function createAndLoginUser(string $email = null): User
    {
        $user = $this->createUser($email);

        $this->client->loginUser($user);

        return $user;
    }

    protected function makeBasicAccessDeniedTest(string $method, string $uri): void
    {
        $this->client->request($method, $uri);

        $response = $this->client->getResponse();
        $responseData = $this->jsonResponseToData($response);

        $this->assertResponseStatusCodeSame(403);
        $this->assertJsonResponse($response);
        $this->assertJsonErrorSchema($responseData);
    }

    protected function assertJsonResponse(Response $response): void
    {
        $content = $response->getContent() ?: '';

        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($content);
    }

    /**
     * @param mixed[] $json
     */
    protected function assertJsonSuccessSchema(array $json): void
    {
        $this->assertJsonDocumentMatchesSchema($json, [
            'type' => 'object',
            'required' => ['success'],
            'properties' => [
                'success' => ['type' => 'boolean'],
            ],
        ]);
    }

    /**
     * @param mixed[] $json
     * @param mixed[] $payloadSchema
     */
    protected function assertJsonMatchesSuccessSchema(array $json, array $payloadSchema): void
    {
        $this->assertJsonDocumentMatchesSchema($json, [
            'type' => 'object',
            'required' => ['success', 'payload'],
            'properties' => [
                'success' => ['type' => 'boolean'],
                'payload' => $payloadSchema,
            ],
        ]);
    }

    /**
     * @param mixed[] $json
     */
    protected function assertJsonErrorSchema(array $json): void
    {
        $this->assertJsonDocumentMatchesSchema($json, [
            'type' => 'object',
            'required' => ['success', 'error'],
            'properties' => [
                'success' => ['type' => 'boolean'],
                'error' => [
                    'type' => 'object',
                    'required' => ['message'],
                    'properties' => [
                        'message' => ['type' => 'string'],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @return mixed[]
     */
    protected function jsonResponseToData(Response $response): array
    {
        $content = $response->getContent() ?: '';

        $data = json_decode($content, true);

        if (!is_array($data)) {
            return [];
        }

        return $data;
    }

    /**
     * @param mixed[] $data
     */
    protected function toJson(array $data): string
    {
        /** @var string */
        return json_encode($data);
    }
}
