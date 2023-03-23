<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyController;
use Symfony\Component\HttpFoundation\JsonResponse;
use SymfonyExtension\Http\Output\AbstractOutput;

abstract class AbstractController extends SymfonyController
{
    /**
     * @param array<string,mixed> $headers
     */
    public function jsonOutput(AbstractOutput $output, int $status = 200, $headers = []): JsonResponse
    {
        return new JsonResponse($output->toArray(), $status, $headers);
    }
}
