<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\FirstTestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstTestController extends AbstractController
{
    public function __construct(
        private FirstTestRepository $firstTestRepository
    ) {
    }

    #[Route('api/v1/first-test', methods: ['GET', 'HEAD'], name: 'api.first-test')]
    public function index(): Response
    {
        return $this->json($this->firstTestRepository->findAll());
    }
}
