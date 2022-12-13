<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Exceptions\CanOnlyThrowObjectsException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class ThrowOperator extends EasyStatement
{

    public function __construct(private readonly Statement $statement)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $rl = $this->statement->getValue($currentEnvironment, $exHandler);
        if ($rl instanceof DataReturnLoad === false) { return $rl; }
        $exception = $rl->getData();
        if ($exception instanceof FunctionObject === false) {
            $r = $exHandler->handle(new CanOnlyThrowObjectsException());
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
        }
        $result = $exHandler->handle($exception);
        if ($result instanceof ExceptionHandlingResultShove) {
            return new DataReturnLoad($result->getShoveBackValue());
        }
        if ($result instanceof ExceptionHandlingResultNoShove) {
            return new ExceptionReturnLoad($result->getExecutionResult());
        }
        throw new ShouldntHappenException();
    }

}