<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use ReflectionFunction;

class PHPFunction extends PHPFunctionContainer
{

    /**
     * @param ReflectionFunction $function
     */
    public function __construct(private readonly ReflectionFunction $function)
    {
        parent::__construct($function);
    }

    public function invoke(DataFunctionParenthesis $parenthesis): mixed
    {
        $parameters = [];
        foreach ($parenthesis->getParameters() as $parameter) {
            $parameters[] = $parameter->getData()->phpV();
        }

        return $this->function->invokeArgs($parameters);
    }
}