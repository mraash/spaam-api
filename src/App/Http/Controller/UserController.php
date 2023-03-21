<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Http\Output\ResourceOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('v1/users/me', methods: 'GET', name: 'api.v1.users.me')]
    public function me(): JsonResponse
    {
        $user = $this->getUser();

        return $this->jsonOutput(new ResourceOutput($user));
    }
}
