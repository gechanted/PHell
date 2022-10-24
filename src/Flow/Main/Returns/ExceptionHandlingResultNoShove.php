<?php

namespace PHell\Flow\Main\Returns;

use PHell\Flow\Main\ExceptionHandlingResult;
use PHell\Flow\Main\Returns\ExecutionResult;

class ExceptionHandlingResultNoShove implements ExceptionHandlingResult
{

    public function __construct(private readonly ExecutionResult $executionResult)
    {
    }

    public function getExecutionResult(): ExecutionResult
    {
        return $this->executionResult;
    }
}