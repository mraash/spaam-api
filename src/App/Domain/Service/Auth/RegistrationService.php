<?php

declare(strict_types=1);

namespace App\Domain\Service\Auth;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\Domain\Service\Auth\Exceptions\UserAlreadyExistsException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function register(string $email, string $plainPassword): User
    {
        if ($this->userRepository->findByEmail($email) !== null) {
            throw new UserAlreadyExistsException();
        }

        $user = new User();

        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);

        $user
            ->setEmail($email)
            ->setPassword($hashedPassword)
        ;

        $this->userRepository->save($user);
        $this->userRepository->flush();

        return $user;
    }
}
