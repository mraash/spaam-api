<?php

declare(strict_types=1);

namespace Tests\App\Functional;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Helmich\JsonAssert\JsonAssertions;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractWebTestCase extends WebTestCase
{
    use JsonAssertions;

    protected KernelBrowser $client;
    protected EntityManager $em;
    protected EntityRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $entityClass = $this->getEntityClass();

        $this->client = self::createClient();
        /** @var EntityManager */
        $this->em = self::getContainer()->get('doctrine.orm.entity_manager');

        if (is_string($entityClass)) {
            $this->repository = $this->em->getRepository($entityClass);
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->em->close();

        unset($this->client);
        unset($this->em);
    }

    protected function getEntityClass(): ?string
    {
        return null;
    }

    protected function loginUser(): User
    {
        $user = new User();

        $user
            ->setEmail('test1@test.com')
            ->setPassword('123')
        ;

        $this->em->persist($user);
        $this->em->flush();

        $this->client->loginUser($user);

        return $user;
    }

    protected function makeBasicAccessDeniedTest(string $method, string $uri): void
    {
        $this->client->request($method, $uri);

        $response = $this->client->getResponse();

        $this->assertResponseStatusCodeSame(403);
        $this->assertJsonResponse($response);
    }

    protected function assertJsonResponse(Response $response): void
    {
        $content = $response->getContent() ?: '';

        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertJson($content);
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
}
