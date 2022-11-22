<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;
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

    public function invoke(FunctionParenthesis $parenthesis): mixed
    {
        $parameters = [];
        foreach ($parenthesis->getParameters() as $parameter) {
            $parameters[] = $parameter->getData()->v();
            //TODO !! if array convert array back to PHP values
            //TODO !! if PHP object  use PHP object and not the PHell object
        }

        return $this->function->invokeArgs($parameters);
    }
}