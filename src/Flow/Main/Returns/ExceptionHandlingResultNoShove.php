<?php

namespace PHell\Flow\Main\Returns;

use PHell\Constructs\TryCatch\TryConstruct;

class ExceptionHandlingResultNoShove extends ExceptionHandlingResult
{

    public function __construct(object $handler, private readonly ExecutionResult $executionResult)
    {
        parent::__construct($handler);
    }

    public function getExecutionResult(): ExecutionResult
    {
        return $this->executionResult;
    }
}