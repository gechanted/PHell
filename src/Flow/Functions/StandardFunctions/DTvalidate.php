<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\Boolea;
use PHell\Flow\Data\Data\DatatypeData;
use PHell\Flow\Data\Datatypes\BooleanType;
use PHell\Flow\Data\Datatypes\DatatypeDataType;
use PHell\Flow\Data\Datatypes\UnknownDatatype;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\Parenthesis\NamedDataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\ValidatorFunctionParenthesisParameter;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class DTvalidate extends StandardLambdaFunction implements Statement
{

    private const datatype = 'datatype';
    private const toCheck = 'toCheck';

    public const FUNCTION_NAME = 'dt_validate';

    public function __construct()
    {
        parent::__construct(self::FUNCTION_NAME, new ValidatorFunctionParenthesis(
            [new ValidatorFunctionParenthesisParameter(self::datatype, new DatatypeDataType()),
                new ValidatorFunctionParenthesisParameter(self::toCheck, new UnknownDatatype())],
            new BooleanType()));

    }

    public function getReturnLoad(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler, NamedDataFunctionParenthesis $parenthesis, FunctionObject $stack,): ReturnLoad
    {
        $datatype = $parenthesis->getParameter(self::datatype)->getData();
        $toCheck = $parenthesis->getParameter(self::toCheck)->getData();

        //kinda already ruled out by the parenthesis checking this
        $dtValidator = new DatatypeDataType;
        if ($dtValidator->validate($datatype)->isSuccess() === false || $datatype instanceof DatatypeData === false) {
            throw new ShouldntHappenException();
        }

        return new DataReturnLoad(new Boolea($datatype->v()->validate($toCheck)->isSuccess()));
    }
}