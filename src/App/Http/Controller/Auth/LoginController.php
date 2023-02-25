<?php

declare(strict_types=1);

namespace App\Http\Controller\Auth;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/v1/auth/access-token', methods: 'GET', name: 'api.auth.login')]
    public function token(): never
    {
        throw new LogicException('This method should not be called.');
    }
}
