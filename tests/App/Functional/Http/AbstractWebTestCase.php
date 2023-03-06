<?php

declare(strict_types=1);

namespace Tests\App\Functional\Http;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Helmich\JsonAssert\JsonAssertions;
use LogicException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use UnexpectedValueException;

abstract class AbstractWebTestCase extends WebTestCase
{
    use JsonAssertions;

    private KernelBrowser $client;
    private EntityManager $em;
    /** @var EntityRepository<object> */
    private ?EntityRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $client = self::createClient();

        /** @var EntityManager */
        $em = self::getContainer()->get('doctrine.orm.entity_manager');

        $entityClass = $this->getEntityClass();

        $this->client = $client;
        $this->em = $em;

        if (is_string($entityClass)) {
            $this->repository = $em->getRepository($entityClass);
        }
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
     * @return EntityRepository<object>
     */
    protected function getRepository(): EntityRepository
    {
        if ($this->repository === null) {
            throw new LogicException('Before using repository, add getEntityClass method.');
        }

        return $this->repository;
    }

    protected function getClient(): KernelBrowser
    {
        return $this->client;
    }

    protected function getEntityManager(): EntityManager
    {
        return $this->em;
    }

    /**
     * Required for the repository.
     *
     * If returns null, the $this->getRepository() method will not be available.
     *
     * @phpstan-return class-string|null
     */
    protected function getEntityClass(): ?string
    {
        return null;
    }

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
