<?php

declare(strict_types=1);

namespace App\Domain\Service\FirstTest;

use App\Domain\Entity\FirstTest;
use App\Domain\Exception\FirstTest\FirstTestNotFoundException;
use App\Domain\Repository\FirstTestRepository;

class FirstTestService
{
    public function __construct(
        private FirstTestRepository $repository
    ) {
    }

    /**
     * @return FirstTest[]
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): FirstTest
    {
        return $this->repository->find($id) ?? throw new FirstTestNotFoundException($id);
    }
}
