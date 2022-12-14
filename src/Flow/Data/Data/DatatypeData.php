<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\DatatypeDataType;
use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class DatatypeData extends DatatypeDataType implements DataInterface
{

    public function __construct(private readonly DatatypeInterface $datatype)
    {
    }

    public function v(): DatatypeInterface
    {
       return $this->datatype;
    }

    public function phpV(): DatatypeInterface
    {
        return $this->v();
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return self::TYPE_DATATYPE.'('.$this->datatype->dumpType().')';
    }

    public function __toString(): string
    {
        return Dump::dump($this);
    }
}