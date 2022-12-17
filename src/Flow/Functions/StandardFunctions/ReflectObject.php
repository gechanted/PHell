<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\PHellObjectDatatype;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesisParameter;
use PHell\Flow\Functions\PHPObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
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

    public function getReturnLoad(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler, NamedDataFunctionParenthesis $parenthesis, FunctionObject $stack,): ReturnLoad
    {
        foreach ($parenthesis->getParameters() as $parameter) {
            return new DataReturnLoad(new PHPObject($parameter->getData()));
        }
        throw new ShouldntHappenException('');
    }
}