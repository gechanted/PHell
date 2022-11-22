<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\VoidType;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class Voi extends VoidType implements DataInterface
{
    public function v()
    {
        return null;
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return self::TYPE_VOID;
    }
}