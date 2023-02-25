<?php

declare(strict_types=1);

namespace App\Http\Controller\Auth;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    #[Route('/v1/auth/login', methods: 'GET', name: 'api.auth.login')]
    public function login(): never
    {
        throw new LogicException('This method should not be called.');
    }

    #[Route('/v1/auth/token/refresh', methods: 'POST', name: 'api.auth.token.refresh')]
    public function refreshToken(): never
    {
        throw new LogicException('This method should not be called.');
    }
}
