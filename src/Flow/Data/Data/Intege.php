<?php
namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class Intege extends IntegerType implements DataInterface
{
    public function __construct(private readonly int $value)
    {
    }

    public function v(): int
    {
        return $this->value;
    }

    public function phpV(): int
    {
        return $this->v();
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return Dump::dump($this);
    }
}