<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\PHellObjectDatatype;
use PHell\Flow\Exceptions\ExtendOnNotObjectException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Statement;

class ExtendOperator implements Command
{

    public function __construct(private readonly Statement $functionObject)
    {
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $RL = $this->functionObject->getValue($currentEnvironment, $exHandler);
        if ($RL instanceof DataReturnLoad === false) { return EasyStatement::returnLoadToExecutionResult($RL); }
        $data = $RL->getData();
        $validator = new PHellObjectDatatype(null);
        if ($validator->validate($data)->isSuccess() === false) {
            $exceptionReturn = $exHandler->transmit(new ExtendOnNotObjectException($data));
            return new ExecutionResult(new ReturningExceptionAction($exceptionReturn->getHandler(), new ExecutionResult()));
        }

        if ($data instanceof FunctionObject === false) { throw new ShouldntHappenException(); }
        return $currentEnvironment->getObject()->extend($data, $exHandler);
    }
}