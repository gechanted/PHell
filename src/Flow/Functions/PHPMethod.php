<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;
use ReflectionMethod;

class PHPMethod extends PHPFunctionContainer
{

    public function __construct(private readonly ReflectionMethod $function, private readonly object $object)
    {
        parent::__construct($this->function);
    }

    public function invoke(FunctionParenthesis $parenthesis): mixed
    {
        $parameters = [];
        foreach ($parenthesis->getParameters() as $parameter) {
            $parameters[] = $parameter->getData()->v();
        }

        return $this->function->invokeArgs($this->object, $parameters);
    }
}