<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\ArgumentResolver\Input;

use ReflectionClass;
use SymfonyExtension\Http\ArgumentResolver\Input\Exception\RequestBodyConvertException;
use SymfonyExtension\Http\ArgumentResolver\Input\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use SymfonyExtension\Http\Attribute\Input\AbstractAsInput;
use SymfonyExtension\Http\Attribute\Input\AsJsonBodyInput;
use SymfonyExtension\Http\Attribute\Input\AsQueryInput;
use Throwable;

class InputArgumentResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private DenormalizerInterface $denormalizer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * @return mixed[]
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        // TODO: Refactor this poop.

        /** @phpstan-var class-string */
        $argumentType = $argument->getType();
        $argumentReflection = new ReflectionClass($argumentType);

        $jsonBodyAttrubute = $argumentReflection->getAttributes(AsJsonBodyInput::class)[0] ?? null;

        if ($jsonBodyAttrubute) {
            $jsonBodyAttribute = $jsonBodyAttrubute->newInstance();
            $content = $request->getContent();

            try {
                $input = $this->serializer->deserialize($content, $argumentType, JsonEncoder::FORMAT);
            }
            catch (Throwable $err) {
                $this->handleInputConvertationException($err);
            }

            $this->validateInputIfNeeded($input, $jsonBodyAttribute);

            return [$input];
        }

        $queryAttribute = $argumentReflection->getAttributes(AsQueryInput::class)[0] ?? null;

        if ($queryAttribute) {
            $queryAttribute = $queryAttribute->newInstance();
            $params = $request->query->all() + $request->files->all();

            try {
                $input = $this->denormalizer->denormalize($params, $argumentType);
            }
            catch (Throwable $err) {
                $this->handleInputConvertationException($err);
            }

            $this->validateInputIfNeeded($input, $queryAttribute);

            return [$input];
        }

        return [];
    }

    private function handleInputConvertationException(Throwable $throwable): never
    {
        throw new RequestBodyConvertException($throwable);
    }

    private function validateInputIfNeeded(mixed $input, AbstractAsInput $attrbute): void
    {
        if ($attrbute->validate) {
            $validationErrors = $this->validator->validate($input);

            if (count($validationErrors) > 0) {
                throw new ValidationException($validationErrors);
            }
        }
    }
}
