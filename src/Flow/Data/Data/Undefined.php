<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\UndefinedType;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class Undefined extends UndefinedType implements DataInterface
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
        return self::TYPE_UNDEFINED;
    }
}