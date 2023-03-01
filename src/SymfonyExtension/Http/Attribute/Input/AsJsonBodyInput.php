<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Attribute\Input;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class AsJsonBodyInput extends AbstractAsInput
{
}
