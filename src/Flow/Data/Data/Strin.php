<?php
namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\StringType;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class Strin extends StringType implements DataInterface
{
    public function __construct(private readonly string $value)
    {
    }

    public function v(): string
    {
        return $this->value;
    }

    public function phpV(): string
    {
        return $this->v();
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return '"'.Dump::stringEscape($this->value).'"';
    }

    public function __toString(): string
    {
        return $this->v();
    }
}