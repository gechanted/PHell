<?php
namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Functions\RunningFunction;
use Phell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

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

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return $this->value;
    }
}