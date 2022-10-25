<?php
namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\StringType;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use Phell\Flow\Main\Statement;

class Strin extends StringType implements DataInterface
{
    public function __construct(private readonly string $value)
    {
    }

    public function getString(): string
    {
        return $this->value;
    }

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult
    {
        return new ExecutionResult();
    }

    public function v()
    {
        return $this->value;
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new DataReturnLoad($this);
    }
}