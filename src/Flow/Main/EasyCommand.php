<?php

namespace PHell\Flow\Main;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\Returns\ExecutionResult;

abstract class EasyCommand implements Command
{
    protected CodeExceptionTransmitter $upper;

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult
    {
        $this->upper = $upper;
        return $this->exec($currentEnvironment);
    }

    abstract protected function exec(FunctionObject $currentEnvironment): ExecutionResult;

}