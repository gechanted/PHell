<?php
namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use Phell\Flow\Main\Statement;

class Intege extends IntegerType implements DataInterface
{
    public function __construct(private readonly int $value)
    {
    }

    public function getInt(): int
    {
        return $this->value;
    }

    public function v()
    {
        return $this->value;
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return $this->value;
    }
}