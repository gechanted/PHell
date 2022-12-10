<?php

namespace PHell\Operators;

use PHell\Flow\Data\Data\Voi;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\CommandActions\ShoveAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Statement;

class ShoveOperator implements Command
{

    public function __construct(private readonly ?Statement $value = null)
    {
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        if ($this->value !== null) {
            $rl = $this->value->getValue($currentEnvironment, $exHandler);
            if ($rl instanceof DataReturnLoad === false) { return EasyStatement::returnLoadToExecutionResult($rl); }
            $data = $rl->getData();
        } else {
            $data = new Voi();
        }
        return new ExecutionResult(new ShoveAction($data));
    }
}