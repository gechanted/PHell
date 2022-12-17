<?php

namespace PHell\Flow\Main;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CommandActions\ReturnAction;
use PHell\Flow\Main\Returns\CatapultReturnLoad;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

abstract class EasyStatement implements Statement
{
    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $return = $this->getValue($currentEnvironment, $exHandler);
        return self::returnLoadToExecutionResult($return);
    }

    public static function returnLoadToExecutionResult(ReturnLoad $returnLoad): ExecutionResult
    {
        if ($returnLoad instanceof DataReturnLoad) {
            return new ExecutionResult();
        } elseif ($returnLoad instanceof ExceptionReturnLoad) {
            return $returnLoad->getExecutionResult();
        } elseif ($returnLoad instanceof CatapultReturnLoad) {
            return new ExecutionResult(new ReturnAction($returnLoad->getData(), $returnLoad->getTarget()));
        }
        throw new ShouldntHappenException();
    }
}