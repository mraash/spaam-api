<?php

declare(strict_types=1);

namespace App\Domain\Service\User;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use App\Domain\Service\User\Exceptions\UserAlreadyExistsException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountFactory
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function createAccount(string $email, string $plainPassword): User
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
