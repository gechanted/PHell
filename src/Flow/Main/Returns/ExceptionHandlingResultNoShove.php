<?php

namespace PHell\Flow\Main\Returns;

use PHell\Commands\TryCatch\TryConstruct;

class ExceptionHandlingResultNoShove extends ExceptionHandlingResult
{

    public function __construct(TryConstruct $handler, private readonly ExecutionResult $executionResult)
    {
        parent::__construct($handler);
    }

    public function getExecutionResult(): ExecutionResult
    {
        return $this->executionResult;
    }
}