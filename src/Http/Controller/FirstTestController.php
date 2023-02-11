<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Domain\Service\FirstTest\FirstTestService;
use App\Http\Response\FirstTest\FirstTestIndexResponse;
use App\Http\Response\FirstTest\FirstTestInfo;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class FirstTestController extends AbstractController
{
    public function __construct(
        private FirstTestService $firstTestService
    ) {
    }

    #[OA\Response(
        response: 200,
        description: 'Get all FirstTest.',
        content: new OA\JsonContent(ref: new Model(type: FirstTestIndexResponse::class)),
    )]
    #[Route('/api/v1/first-test', methods: ['GET'], name: 'api.first-test')]
    public function index(): JsonResponse
    {
        $firstTests = $this->firstTestService->findAll();

        $response = new FirstTestIndexResponse($firstTests);

        return $this->json($response);
    }

    #[Route('/api/v1/first-test/{id}', methods: ['GET'], name: 'api.first-test')]
    public function single(int $id): JsonResponse
    {
        $firstTest = $this->firstTestService->findById($id);

        $response = new FirstTestInfo($firstTest);

        return $this->json($response);
    }
}
