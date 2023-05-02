<?php

declare(strict_types=1);

namespace App\Http\Request\Input\Auth;

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Input\Input\AbstractJsonBodyInput;

class RegisterInput extends AbstractJsonBodyInput
{
    protected static function fields(): array
    {
        return [
            'email' => new Required([
                new NotBlank(),
                new Type('string'),
                new Email(),
                new Length(
                    max: 180
                ),
            ]),
            'password' => new Required([
                new NotBlank(),
                new Type('string'),
            ]),
            'passwordRepeat' => new Required([
                new NotBlank(),
                new Type('string'),
                new EqualTo(
                    propertyPath: 'password',
                    message: 'This value should be equal to password.'
                ),
            ]),
        ];
    }

    public function getEmail(): string
    {
        /** @var string */
        return $this->getParam('email');
    }

    public function getPssword(): string
    {
        /** @var string */
        return $this->getParam('password');
    }

    public function getPasswordRepeat(): string
    {
        /** @var string */
        return $this->getParam('passwordRepeat');
    }
}
