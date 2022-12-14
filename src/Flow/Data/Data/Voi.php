<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\VoidType;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class Voi extends VoidType implements DataInterface
{
    public function v()
    {
        return null;
    }

    public function phpV()
    {
        return $this->v();
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return self::TYPE_VOID;
    }

    public function __toString(): string
    {
        return Dump::dump($this);
    }
}