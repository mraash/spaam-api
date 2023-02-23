<?php

declare(strict_types=1);

namespace App\Http\Request\Auth;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class RegisterRequest
{
    #[NotBlank]
    #[Type('string')]
    #[Email]
    #[Length(max: 180)]
    public $email;

    #[NotBlank]
    #[Type('string')]
    public $password;

    #[NotBlank]
    #[Type('string')]
    #[EqualTo(propertyPath: 'password', message: 'This password should be equal to password.')]
    public $passwordRepeat;
}
