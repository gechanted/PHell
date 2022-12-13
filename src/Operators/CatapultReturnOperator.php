<?php

namespace PHell\Operators;

use PHell\Flow\Data\Data\RunningFunctionData;
use PHell\Flow\Exceptions\CatapultReturnException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\CommandActions\ReturnAction;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Statement;

class CatapultReturnOperator implements Command
{

    public function __construct(private readonly Statement $runningFunction, private readonly Statement $returnValue)
    {
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $runningFunctionRL = $this->runningFunction->getValue($currentEnvironment, $exHandler);
        if ($runningFunctionRL instanceof DataReturnLoad === false) { EasyStatement::returnLoadToExecutionResult($runningFunctionRL); }
        $runningFunction = $runningFunctionRL->getData();
        if ($runningFunction instanceof RunningFunctionData === false) {
            $exceptionResult = $exHandler->handle(new CatapultReturnException($runningFunction));
            return new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult()));
        }

        $returnValueRL = $this->returnValue->getValue($currentEnvironment, $exHandler);
        if ($returnValueRL instanceof DataReturnLoad === false) { EasyStatement::returnLoadToExecutionResult($returnValueRL); }

        return new ExecutionResult(new ReturnAction($returnValueRL->getData()));
    }
}