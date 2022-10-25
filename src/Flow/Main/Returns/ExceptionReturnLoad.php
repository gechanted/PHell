<?php

namespace Phell\Flow\Main\Returns;


class ExceptionReturnLoad implements ReturnLoad
{

    public function __construct(private readonly ExecutionResult $executionResult)
    {
    }

    public function getExecutionResult(): ExecutionResult
    {
        return $this->executionResult;
    }
}