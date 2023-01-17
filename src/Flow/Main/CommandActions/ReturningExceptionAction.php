<?php

namespace PHell\Flow\Main\CommandActions;

use PHell\Flow\Main\Returns\ExecutionResult;

class ReturningExceptionAction implements CommandAction
{

    public function __construct(private readonly object $handler, private readonly ExecutionResult $executionResult)
    {
    }

    public function getExecutionResult(): ExecutionResult
    {
        return $this->executionResult;
    }

    public function getHandler(): object
    {
        return $this->handler;
    }

}