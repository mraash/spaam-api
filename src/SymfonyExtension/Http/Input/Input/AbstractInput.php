<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Input\Input;

use InvalidArgumentException;
use Symfony\Component\Validator\Constraints\Collection;

abstract class AbstractInput
{
    public const REQUEST_TYPE_JSON_BODY = 1;
    public const REQUEST_TYPE_GET_QUERY = 2;
    public const REQUEST_TYPE_POST_QUERY = 3;

    /** @var array<string,mixed> */
    private array $params;

    /**
     * @param array<string,mixed> $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return int[] Array of self::REQUEST_TYPE constants.
     */
    abstract public static function allowedRequestTypes(): array;

    /**
     * Note: All Collection::fields constraints should be wrapped in Existence
     *   (Required, Optional, etc.) constraint.
     */
    abstract public static function rules(): Collection;

    /**
     * @return array<string,mixed>
     */
    public function params(): array
    {
        return $this->params;
    }

    public function getParamOrNull(string $key): mixed
    {
        return $this->params[$key] ?? null;
    }

    public function hasParam(string $key): bool
    {
        return array_key_exists($key, $this->params);
    }

    public function getParam(string $key): mixed
    {
        if (!$this->hasParam($key)) {
            throw new InvalidArgumentException(sprintf('Undefined param key %s', $key));
        }

        return $this->getParamOrNull($key);
    }
}
