<?php

declare(strict_types=1);

namespace App\Http\Controller;

use App\Domain\Service\User\AccountFactory;
use App\Http\Request\Auth\RegisterInput;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    public function __construct(
        private AccountFactory $accountFactory,
        private AuthenticationSuccessHandler $authenticationSuccessHandler,
    ) {
    }

    #[Route('/v1/auth/register', methods: 'POST', name: 'api.v1.auth.register')]
    public function register(RegisterInput $input): Response
    {
        $email = $input->getEmail();
        $password = $input->getPssword();

        $user = $this->accountFactory->createAccount($email, $password);

        $response = $this->authenticationSuccessHandler->handleAuthenticationSuccess($user);

        return $response;
    }

    #[Route('/v1/auth/login', methods: 'GET', name: 'api.v1.auth.login')]
    public function login(): never
    {
        // Route is activated in config/packages/security.yaml
        throw new LogicException('This method should not be called.');
    }

    #[Route('/v1/auth/token/refresh', methods: 'POST', name: 'api.v1.auth.token.refresh')]
    public function refreshToken(): never
    {
        // Route is activated in config/packages/security.yaml
        throw new LogicException('This method should not be called.');
    }
}
