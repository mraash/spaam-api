<?php

declare(strict_types=1);

namespace App\Http\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('v1/users/me', methods: 'GET', name: 'api.users.me')]
    public function me(): JsonResponse
    {
        return $this->json($this->getUser());
    }
}
