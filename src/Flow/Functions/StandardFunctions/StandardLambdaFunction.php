<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\LambdaFunction;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use Phell\Flow\Main\Code;
use Phell\Flow\Main\Statement;

class StandardLambdaFunction extends LambdaFunction
{

    public function __construct(string $name, ValidatorFunctionParenthesis $parenthesis, private readonly Statement $function)
    {
        parent::__construct($name, null, $parenthesis, new Code());
    }

    public function generateRunningFunction(DataFunctionParenthesis $parenthesis, FunctionObject $stack): Statement
    {
        return $this->function;
    }
}