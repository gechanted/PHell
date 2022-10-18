<?php

namespace PHell\Operators;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\ExceptionReturnLoad;
use PHell\Flow\Main\ReturnLoad;
use PHell\Flow\Main\Statement;

class ThrowOperator extends EasyStatement
{

    public function __construct(private readonly Statement $statement)
    {
    }

    public function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        $exception = $this->statement->getValue($currentEnvironment, $this->upper);
        if ($exception instanceof FunctionObject === false) //TODO convert to isObject() ?
        {
            //TODO throw an exception here
        }
        $result = $this->upper->transmit($exception);
        if ($result->shallContinue()) {
            return new ReturnLoad($result->getShoveBackValue());
        }
        return new ExceptionReturnLoad();
    }

}