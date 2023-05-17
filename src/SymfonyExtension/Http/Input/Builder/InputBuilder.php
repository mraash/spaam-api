<?php

declare(strict_types=1);

namespace SymfonyExtension\Http\Input\Builder;

use LogicException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use SymfonyExtension\Http\Input\Builder\Exception\JsonBodyDecodeException;
use SymfonyExtension\Http\Input\Validator\Exception\ValidationException;
use SymfonyExtension\Http\Input\Input\AbstractInput;
use SymfonyExtension\Http\Input\TypeConverter\TypeConverter;
use SymfonyExtension\Http\Input\Validator\InputValidator;

class InputBuilder
{
    public function __construct(
        private TypeConverter $typeConverter,
        private InputValidator $inputValidator,
    ) {
    }

    /**
     * @phpstan-param class-string<AbstractInput> $inputClass
     */
    public function buildValid(Request $request, string $inputClass): AbstractInput
    {
        return $this->build($request, $inputClass, true);
    }

    /**
     * @phpstan-param class-string<AbstractInput> $inputClass
     */
    public function build(Request $request, string $inputClass, bool $validate): AbstractInput
    {
        // todo: Add some abstractions here

        /** @var Collection */
        $rules = $inputClass::rules();
        /** @var string[] */
        $requestTypes = $inputClass::allowedRequestTypes();

        if (in_array(AbstractInput::REQUEST_TYPE_JSON_BODY, $requestTypes)) {
            $params = json_decode($request->getContent(), true);

            if (!is_array($params)) {
                throw new JsonBodyDecodeException();
            }

            $input = new $inputClass($params);
        }
        elseif (in_array(AbstractInput::REQUEST_TYPE_GET_QUERY, $requestTypes)) {
            $rawParams = $request->query->all() + $request->files->all();
            $params = $this->typeConverter->convertTypes($rawParams, $rules);

            $input = new $inputClass($params);
        }
        elseif (in_array(AbstractInput::REQUEST_TYPE_POST_QUERY, $requestTypes)) {
            $rawParams = $request->request->all() + $request->files->all();
            $params = $this->typeConverter->convertTypes($rawParams, $rules);

            $input = new $inputClass($params);
        }
        else {
            throw new LogicException(
                sprintf('Method %s::allowedRequestTypes() shold return at least one request type.', $inputClass)
            );
        }

        if ($validate) {
            $this->inputValidator->validate($input);
        }

        return $input;
    }
}
