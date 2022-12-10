<?php

namespace PHell\Flow\Main\CommandActions;

use PHell\Commands\TryCatch\TryConstruct;
use PHell\Flow\Main\Returns\ExecutionResult;

class ReturningExceptionAction implements CommandAction
{

    public function __construct(private readonly TryConstruct $handler, private readonly ExecutionResult $executionResult)
    {
    }

    public function getExecutionResult(): ExecutionResult
    {
        return $this->executionResult;
    }

    public function getHandler(): TryConstruct
    {
        return $this->handler;
    }

}