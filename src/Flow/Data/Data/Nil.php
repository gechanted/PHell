<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\NullType;
use PHell\Flow\Functions\RunningFunction;
use Phell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class Nil extends NullType implements DataInterface
{

    public function v()
    {
        return null;
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return self::TYPE_NULL;
    }
}