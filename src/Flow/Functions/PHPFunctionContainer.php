<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;

abstract class PHPFunctionContainer
{
    public function __construct(private readonly \ReflectionFunctionAbstract $function)
    {
    }

    abstract public function invoke(FunctionParenthesis $parenthesis): mixed;

    /** @return \ReflectionParameter[] */
    public function getParameters(): array
    {
        return $this->function->getParameters();
    }

    public function getName(): string
    {
        return $this->function->getName();
    }
}