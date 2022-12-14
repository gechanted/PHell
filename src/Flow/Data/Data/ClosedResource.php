<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\ClosedResourceType;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Lib;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class ClosedResource extends ClosedResourceType implements DataInterface
{

    public function __construct(private $resource)
    {
    }

    public function v()
    {
        return $this->resource;
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
        return self::TYPE_CLOSED_RESOURCE.'('. Lib::dumpAsString($this->resource) .')';
    }

    public function __toString(): string
    {
        return Dump::dump($this);
    }
}