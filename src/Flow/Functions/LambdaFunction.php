<?php

namespace PHell\Flow\Functions;

use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use Phell\Flow\Main\Code;
use Phell\Flow\Main\Statement;

/**
 * the simple, not executed function
 */
class LambdaFunction //implements LambdaFunctionInterface TODO maybe implement an Interface instead of extending this
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

    public function generateRunningFunction(FunctionParenthesis $parenthesis, FunctionObject $stack): Statement //TODO !check if its ok
    {
       return new RunningFunction(new FunctionObject($this->name, $stack, $this->origin, $parenthesis), $this->code, $parenthesis->getReturnType());
    }
}