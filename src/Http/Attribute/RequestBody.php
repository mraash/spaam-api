<?php

declare(strict_types=1);

namespace App\Http\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER)]
class RequestBody
{
}
