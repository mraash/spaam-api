<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Response\Info;

abstract class AbstractInfo
{
    /**
     * @param mixed[] $data
     */
    abstract public static function fromArray(array $data): self;
}
