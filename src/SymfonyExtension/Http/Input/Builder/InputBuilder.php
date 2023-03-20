<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Input\Builder;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use SymfonyExtension\Http\Input\Builder\Exception\JsonBodyDecodeException;
use SymfonyExtension\Http\Input\Builder\Exception\ValidationException;
use SymfonyExtension\Http\Input\Input\AbstractInput;
use SymfonyExtension\Http\Input\TypeConverter\TypeConverter;

class InputBuilder
{
    public function __construct(
        private ValidatorInterface $validator,
        private TypeConverter $typeConverter,
    ) {
    }

    /**
     * @phpstan-param class-string<AbstractInput> $inputClass
     */
    public function build(Request $request, string $inputClass, bool $validate): AbstractInput
    {
        // TODO: Make this more beautiful

        /** @var Collection */
        $rules = $inputClass::rules();
        /** @var string[] */
        $requestTypes = $inputClass::allowedRequestTypes();

        if (in_array(AbstractInput::REQUEST_TYPE_JSON_BODY, $requestTypes)) {
            $params = json_decode($request->getContent(), true);

            if (!is_array($params)) {
                throw new JsonBodyDecodeException();
            }

            if ($validate) {
                $this->validate($params, $rules);
            }

            return new $inputClass($params);
        }

        if (in_array(AbstractInput::REQUEST_TYPE_GET_QUERY, $requestTypes)) {
            $params = $request->query->all() + $request->files->all();

            $params = $this->typeConverter->convertTypes($params, $rules);

            if ($validate) {
                $this->validate($params, $rules);
            }

            return new $inputClass($params);
        }

        if (in_array(AbstractInput::REQUEST_TYPE_POST_QUERY, $requestTypes)) {
            $params = $request->request->all() + $request->files->all();

            $params = $this->typeConverter->convertTypes($params, $rules);

            if ($validate) {
                $this->validate($params, $rules);
            }

            return new $inputClass($params);
        }

        return new $inputClass;
    }

    /**
     * @param mixed[] $params
     */
    private function validate(array $params, Collection $rules): void
    {
        $violations = $this->validator->validate($params, $rules);

        if ($violations->count() > 0) {
            throw new ValidationException($violations);
        }
    }
}
