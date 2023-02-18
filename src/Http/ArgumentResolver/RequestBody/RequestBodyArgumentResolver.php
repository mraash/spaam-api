<?php

declare(strict_types=1);

namespace App\Http\ArgumentResolver\RequestBody;

use App\Http\ArgumentResolver\RequestBody\Exception\RequestBodyConvertException;
use App\Http\ArgumentResolver\RequestBody\Exception\ValidationException;
use App\Http\Attribute\RequestBody;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class RequestBodyArgumentResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator
    ) {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (count($argument->getAttributes(RequestBody::class, ArgumentMetadata::IS_INSTANCEOF)) < 1) {
            return [];
        }

        try {
            $customRequest = $this->serializer->deserialize(
                $request->getContent(),
                $argument->getType(),
                JsonEncoder::FORMAT
            );
        }
        catch (Throwable) {
            throw new RequestBodyConvertException();
        }

        $validationErrors = $this->validator->validate($customRequest);

        if (count($validationErrors) > 0) {
            throw new ValidationException($validationErrors);
        }

        return [$customRequest];
    }
}
