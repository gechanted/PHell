<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Exceptions\CanOnlyThrowObjectsException;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
use Phell\Flow\Main\Statement;

class ThrowOperator extends EasyStatement
{

    public function __construct(private readonly Statement $statement)
    {
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        $exception = $this->statement->getValue($currentEnvironment, $this->upper);
        if ($exception instanceof FunctionObject === false) //TODO maybe convert to isObject() ?
        {
            $this->upper->transmit(new CanOnlyThrowObjectsException());
            return new ExceptionReturnLoad();
        }
        $result = $this->upper->transmit($exception);
        if ($result instanceof ExceptionHandlingResultShove) {
            return new ReturnLoad($result->getShoveBackValue());
        }
        if ($result instanceof ExceptionHandlingResultNoShove) {
            return new ExceptionReturnLoad($result->getExecutionResult());
        }
        throw new ShouldntHappenException();
    }

}