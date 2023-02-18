<?php

declare(strict_types=1);

namespace App\Http\Request\FirstTest;

use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;

class CreateFirstTestRequest
{
    #[NotBlank()]
    public string $strProp;

    public int $intProp;

    #[NotBlank()]
    #[IsTrue]
    public bool $boolProp;
}
