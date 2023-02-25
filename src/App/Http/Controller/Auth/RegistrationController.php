<?php

declare(strict_types=1);

namespace App\Http\Controller\Auth;

use App\Domain\Service\Auth\RegistrationService;
use App\Http\Request\Auth\RegisterRequest;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyExtension\Http\Attribute\RequestBody;

class RegistrationController extends AbstractController
{
    public function __construct(
        private RegistrationService $registrationService,
        private AuthenticationSuccessHandler $authenticationSuccessHandler
    ) {
    }

    #[Route('/v1/auth/register', methods: 'POST', name: 'api.auth.register')]
    public function register(#[RequestBody] RegisterRequest $request): Response
    {
        $email = (string) $request->email;
        $password = (string) $request->password;

        $user = $this->registrationService->register($email, $password);

        $response = $this->authenticationSuccessHandler->handleAuthenticationSuccess($user);

        return $response;
    }
}
