<?php

namespace PHell\Flow\Main;

use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

abstract class EasyStatement implements Command, Statement
{
    protected CodeExceptionTransmitter $upper;

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult
    {
        $return = $this->getValue($currentEnvironment, $upper);
        return new ExecutionResult($return->isExceptionReturn() ? new ReturningExceptionAction() : null);
    }

    abstract protected function value(FunctionObject $currentEnvironment): ReturnLoad;

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        $this->upper = $upper;
        return $this->value($currentEnvironment);
    }
}