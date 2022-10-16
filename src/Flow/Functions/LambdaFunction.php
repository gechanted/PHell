<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Main\Code;

/**
 * the simple, not executed function
 */
class LambdaFunction
{

    public function __construct(
        private readonly string              $name,
        private readonly ?FunctionObject     $origin,
        private readonly ValidatorFunctionParenthesis $parenthesis,
        private readonly Code                $code
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParenthesis(): ValidatorFunctionParenthesis
    {
        return $this->parenthesis;
    }

    public function generateRunningFunction(FunctionParenthesis $parenthesis, FunctionObject $stack): RunningFunction
    {
       return new RunningFunction(new FunctionObject($this->name, $stack, $this->origin, $parenthesis), $this->code, $parenthesis->getReturnType());
    }
}