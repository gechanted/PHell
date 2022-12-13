<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Exceptions\BreakException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\CommandActions\BreakAction;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Statement;

class BreakOperator implements Command
{

    public function __construct(private readonly ?Statement $layers)
    {
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        if ($this->layers === null) {
            $layerInt = 1;
        } else {
            $RL = $this->layers->getValue($currentEnvironment, $exHandler);
            if ($RL instanceof DataReturnLoad === false) { EasyStatement::returnLoadToExecutionResult($RL); }
            $layerData = $RL->getData();

            $validator = new IntegerType();
            if ($validator->validate($layerData)->isSuccess() === false) {
                $exceptionResult = $exHandler->handle(new BreakException($layerData->dumpValue()));
                return new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), new ExecutionResult()));
            }

            $layerInt = $layerData->v();
            if (is_int($layerInt) === false) { throw new ShouldntHappenException(); }
        }

        return new ExecutionResult(new BreakAction($layerInt));
    }
}