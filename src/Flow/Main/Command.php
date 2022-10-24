<?php

namespace PHell\Flow\Main;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\Returns\ExecutionResult;

interface Command
{

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult;
}