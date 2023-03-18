<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('v1/users/me', methods: 'GET', name: 'api.v1.users.me')]
    public function me(): JsonResponse
    {
        $user = $this->getUser();

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'roles' => $user->getRoles(),
        ]);
    }
}
