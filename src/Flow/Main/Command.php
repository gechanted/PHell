<?php

namespace PHell\Flow\Main;

use PHell\Flow\Functions\FunctionObject;

interface Command
{

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult;
}