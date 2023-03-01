<?php

declare(strict_types=1);

namespace App\Http\Request\Auth;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Attribute\Input\AsJsonBodyInput;

#[AsJsonBodyInput]
class RegisterInput
{
    #[NotBlank]
    #[Type('string')]
    #[Email]
    #[Length(max: 180)]
    public mixed $email;

    #[NotBlank]
    #[Type('string')]
    public mixed $password;

    #[NotBlank]
    #[Type('string')]
    #[EqualTo(propertyPath: 'password', message: 'This value should be equal to password.')]
    public mixed $passwordRepeat;

    public function getEmail(): string
    {
        /** @var string */
        return $this->email;
    }

    public function getPssword(): string
    {
        /** @var string */
        return $this->password;
    }

    public function getPasswordRepeat(): string
    {
        /** @var string */
        return $this->passwordRepeat;
    }
}
