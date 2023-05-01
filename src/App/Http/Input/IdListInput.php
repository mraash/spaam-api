<?php

declare(strict_types=1);

namespace App\Http\Input;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Constraints\Type;
use SymfonyExtension\Http\Input\Input\AbstractJsonBodyInput;

class IdListInput extends AbstractJsonBodyInput
{
    protected static function fields(): array
    {
        return [
            'ids' => new Required([
                new NotNull(),
                new Type('array'),
                new All([
                    new NotNull(),
                    new Type('integer'),
                ]),
            ]),
        ];
    }

    /**
     * @return int[]
     */
    public function getIdList(): array
    {
        /** @var int[] */
        return $this->getParam('ids');
    }
}
