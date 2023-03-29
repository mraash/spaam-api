<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Part;

use App\Integration\VKontakte\Exception\ContractException;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ErrorOutput
{
    private function __construct(
        public readonly int $code,
        public readonly string $message,
    ) {
    }

    public static function fromResponse(ResponseInterface $response): self
    {
        return self::fromBodyData($response->toArray());
    }

    /**
     * @param mixed[] $bodyData
     */
    public static function fromBodyData(array $bodyData): self
    {
        $error = $bodyData['error'] ?? throw new ContractException();

        if (!is_array($error)) {
            throw new ContractException();
        }

        return self::fromError($error);
    }

    /**
     * @param mixed[] $error
     */
    protected static function fromError(array $error): self
    {
        $code = $error['error_code'] ?? throw new ContractException();
        $message = $error['error_msg'] ?? throw new ContractException();

        return new self((int) $code, (string) $message);
    }
}
