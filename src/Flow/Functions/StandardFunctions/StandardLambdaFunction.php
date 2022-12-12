<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\LambdaFunction;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\Statement;

abstract class StandardLambdaFunction extends LambdaFunction
{

    public function __construct(string $name, ValidatorFunctionParenthesis $parenthesis)
    {
        parent::__construct($name, null, $parenthesis, new Code());
    }

    public function generateRunningFunction(DataFunctionParenthesis $parenthesis, FunctionObject $stack): Statement
    {
        return $this->getStatement($parenthesis, $stack);
    }

    abstract public function getStatement(DataFunctionParenthesis $parenthesis, FunctionObject $stack): Statement;
}