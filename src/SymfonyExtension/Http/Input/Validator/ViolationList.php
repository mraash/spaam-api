<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Input\Validator;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Traversable;

/**
 * @implements IteratorAggregate<int,Violation>
 */
class ViolationList implements IteratorAggregate, Countable
{
    /** @var Violation[] */
    private array $list;

    /**
     * @param Violation[] $violationList
     */
    public function __construct(array $violationList)
    {
        $this->list = $violationList;
    }

    public static function fromConstraintViolationList(ConstraintViolationListInterface $constraintViolationList): self
    {
        $violationList = [];

        foreach ($constraintViolationList as $constraintViolation) {
            $violationList[] = Violation::fromConstraintViolation($constraintViolation);
        }

        return new self($violationList);
    }

    /**
     * @return ArrayIterator<int,Violation>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->list);
    }

    public function count(): int
    {
        return count($this->list);
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    public function has(int $offset): bool
    {
        return isset($this->list[$offset]);
    }

    public function get(int $offset): Violation
    {
        return $this->list[$offset] ?? throw new InvalidArgumentException(sprintf('Infalid offset %s', $offset));
    }
}
