<?php

namespace PHell\Operators;

use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\CommandActions\ReturnAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Statement;

class ReturnOperator implements Command
{

    public function __construct(private readonly Statement $returnValue)
    {
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $RL = $this->returnValue->getValue($currentEnvironment, $exHandler);
        if ($RL instanceof DataReturnLoad === false) { EasyStatement::returnLoadToExecutionResult($RL); }
        return new ExecutionResult(new ReturnAction($RL->getData()));
    }
}