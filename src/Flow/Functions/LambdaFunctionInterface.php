<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;

interface LambdaFunctionInterface
{
    //TODO implement maybe?

    public function getName(): string;

    public function getParenthesis(): ValidatorFunctionParenthesis;

    public function generateRunningFunction(FunctionParenthesis $parenthesis, FunctionObject $stack): RunningFunction;
}