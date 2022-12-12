<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\PHellObjectDatatype;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesisParameter;
use PHell\Flow\Functions\PHPObject;
use PHell\Flow\Main\Statement;

class ReflectObject extends StandardLambdaFunction
{

    public function __construct()
    {
        parent::__construct('reflectObject',
            new ValidatorFunctionParenthesis(
                [new ValidatorFunctionParenthesisParameter('object', new PHellObjectDatatype(null))],
                new PHellObjectDatatype(null)));
    }

    public function getStatement(DataFunctionParenthesis $parenthesis, FunctionObject $stack): Statement
    {
        foreach ($parenthesis->getParameters() as $parameter) {
            return new PHPObject($parameter->getData());
        }
        throw new ShouldntHappenException('');
    }
}