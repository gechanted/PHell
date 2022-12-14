<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\Statement;

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

    public function dumpParenthesis(): string
    {
        $dump = '';
        foreach ($this->parenthesis->getParameters() as $parameter) {
            if ($dump !== ''){
                $dump .= ', ';
            }
            $dump .= $parameter->getDatatype()->dumpType() . ($parameter->isOptional() ? '(opt)' : '');
        }

        return $dump;
    }

    public function generateRunningFunction(NamedDataFunctionParenthesis $parenthesis, FunctionObject $stack): Statement
    {
       return new RunningFunction(new FunctionObject($this->name, $stack, $this->origin, $parenthesis), $this->code, $parenthesis->getReturnType());
    }

    public function getCode(): Code
    {
        return $this->code;
    }
}