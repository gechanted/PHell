<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Data\Datatypes\StringType;
use PHell\Flow\Data\Datatypes\UnknownDatatype;
use PHell\Flow\Data\Datatypes\VoidType;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesisParameter;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class EchoFunction extends StandardLambdaFunction
{

    public function __construct()
    {
        parent::__construct('echo',
            new ValidatorFunctionParenthesis(
                [new ValidatorFunctionParenthesisParameter('msg', new StringType())],
                new VoidType()));
    }

    public function getReturnLoad(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler, NamedDataFunctionParenthesis $parenthesis, FunctionObject $stack): ReturnLoad
    {
        echo $parenthesis->getParameter('msg')->getData()->v();
        return new DataReturnLoad();
    }

}