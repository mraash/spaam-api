<?php

declare(strict_types=1);

namespace App\Http\Request\SpamPanel;

use SymfonyExtension\Http\Attribute\Input\AsJsonBodyInput;

#[AsJsonBodyInput]
class UpdateSpamPanelInput extends AbstractCreationInput
{
}
