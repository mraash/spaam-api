<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Response\Output;
namespace App\Integration\VKontakte\Response\Output;

use App\Integration\VKontakte\Exception\ContractException;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractOutput
{
    public static function fromResponse(ResponseInterface $response): static
    {
        return static::fromBodyData($response->toArray());
    }

    /**
     * @param mixed[] $bodyData
     */
    public static function fromBodyData(array $bodyData): static
    {
        $data = $bodyData['response'] ?? throw new ContractException();

        if (!is_array($data)) {
            throw new ContractException();
        }

        $output = static::fromData($data);

        /** @phpstan-ignore-next-line */
        return $output;
    }

    /**
     * Create object from $responseData['response'] array.
     *
     * @param mixed[] $data
     */
    abstract protected static function fromData(array $data): self;
}
