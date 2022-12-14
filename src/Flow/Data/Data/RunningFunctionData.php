<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\RunningFunctionDatatype;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class RunningFunctionData extends RunningFunctionDatatype implements DataInterface
{
    public function __construct(private readonly RunningFunction $function)
    {
        parent::__construct($this->function->getReturnType());
    }

    public function v(): RunningFunction
    {
        return $this->function;
    }

    public function phpV(): RunningFunction
    {
        return $this->v();
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return self::TYPE_RUNNINGFUNCTION.'('.($this->function->isActive()?'ACTIVE':'INACTIVE').')<'.$this->function->getReturnType()->dumpType().'>';
    }

    public function __toString(): string
    {
        return Dump::dump($this);
    }
}