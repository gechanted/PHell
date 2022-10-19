<?php
namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\FloatType;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\ExecutionResult;
use PHell\Flow\Main\ReturnLoad;
use PHell\Flow\Main\Statement;

class Floa extends FloatType implements DataInterface
{

    public function __construct(private readonly float $value)
    {
    }

    public function getFloat(): float
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
        return new ReturnLoad($this);
    }
}