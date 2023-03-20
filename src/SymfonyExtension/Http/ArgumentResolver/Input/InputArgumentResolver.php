<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\ArgumentResolver\Input;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use SymfonyExtension\Http\Input\Builder\InputBuilder;
use SymfonyExtension\Http\Input\Input\AbstractInput;

class InputArgumentResolver implements ValueResolverInterface
{
    public function __construct(
        private InputBuilder $inputBuilder,
    ) {
    }

    /**
     * @return mixed[]
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        /** @phpstan-var class-string */
        $argumentType = $argument->getType();

        if (is_subclass_of($argumentType, AbstractInput::class)) {
            $input = $this->inputBuilder->build($request, $argumentType, true);

            return [$input];
        }

        return [];
    }
}
