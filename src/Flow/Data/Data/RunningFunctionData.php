<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\RunningFunctionDatatype;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class RunningFunctionData extends RunningFunctionDatatype implements DataInterface
{
    public function __construct(private readonly RunningFunction $function)
    {
        parent::__construct($this->function->getReturnType());
    }

    public function v()
    {
        return $this->function;
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return self::TYPE_RUNNINGFUNCTION.'('.($this->function->isActive()?'ACTIVE':'INACTIVE').')<'.$this->function->getReturnType()->dumpType().'>';
    }
}