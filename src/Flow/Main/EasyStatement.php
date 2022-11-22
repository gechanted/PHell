<?php

namespace PHell\Flow\Main;

use PHell\Flow\Functions\RunningFunction;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;

abstract class EasyStatement implements Command, Statement
{
    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $return = $this->getValue($currentEnvironment, $exHandler);

        return
            ($return instanceof ExceptionReturnLoad
                ? $return->getExecutionResult()
                : new ExecutionResult());
        //TODO new Returnload
    }
}