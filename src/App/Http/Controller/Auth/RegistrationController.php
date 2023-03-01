<?php

declare(strict_types=1);

namespace App\Http\Controller\Auth;

use App\Domain\Service\User\AccountFactory;
use App\Http\Request\Auth\RegisterInput;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private AccountFactory $accountFactory,
        private AuthenticationSuccessHandler $authenticationSuccessHandler
    ) {
    }

    #[Route('/v1/auth/register', methods: 'POST', name: 'api.auth.register')]
    public function register(RegisterInput $input): Response
    {
        $email = $input->getEmail();
        $password = $input->getPssword();

        $user = $this->accountFactory->createAccount($email, $password);

        $response = $this->authenticationSuccessHandler->handleAuthenticationSuccess($user);

        return $response;
    }
}
