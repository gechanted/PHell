<?php

namespace PHell\Flow\Main;

use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\Returns\ExecutionResult;

interface Command
{
    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult;
}