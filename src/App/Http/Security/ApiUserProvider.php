<?php

declare(strict_types=1);

namespace App\Http\Security;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\PayloadAwareUserProviderInterface;
use LogicException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class ApiUserProvider implements PayloadAwareUserProviderInterface
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function supportsClass(string $class): bool
    {
        return $class == User::class || is_subclass_of($class, User::class);
    }

    /**
     * Load user by email.
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->findUser('email', $identifier);
    }

    /**
     * Load user by id field in payload.
     *
     * @param array<string|int,mixed> $payload
     */
    public function loadUserByIdentifierAndPayload(string $identifier, array $payload): UserInterface
    {
        return $this->findUser('id', $payload['id']);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        throw new LogicException('User refresh not used.');
    }

    /**
     * @param array<string|int,mixed> $payload
     */
    public function loadUserByUsernameAndPayload(string $username, array $payload): UserInterface
    {
        throw new LogicException('Attempt to use deprecated method.');
    }

    private function findUser(string $identifierColumn, mixed $value): User
    {
        $user = $this->userRepository->findOneBy([$identifierColumn => $value]);

        if ($user === null) {
            $err = new UserNotFoundException();
            $err->setUserIdentifier((string) $value);
            throw $err;
        }

        return $user;
    }
}
