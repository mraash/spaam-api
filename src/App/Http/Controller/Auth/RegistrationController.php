<?php

declare(strict_types=1);

namespace App\Http\Controller\Auth;

use App\Domain\Service\Auth\RegistrationService;
use App\Http\Request\Auth\RegisterRequest;
use App\Http\Response\Auth\RegistrationResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyExtension\Http\Attribute\RequestBody;

class RegistrationController extends AbstractController
{
    public function __construct(
        private RegistrationService $registrationService
    ) {
    }

    #[Route('/v1/auth/register', methods: 'POST', name: 'api.auth.register')]
    public function register(#[RequestBody] RegisterRequest $request): JsonResponse
    {
        $email = (string) $request->email;
        $password = (string) $request->password;

        $user = $this->registrationService->register($email, $password);

        $response = new RegistrationResponse($user);

        return $this->json($response);
    }
}
