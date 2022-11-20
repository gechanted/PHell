<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\AbstractType;
use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Data\Datatypes\DatatypeValidation;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class DatatypeData extends AbstractType implements DataInterface
{

    const TYPE_DATATYPE = 'datatype';

    public function __construct(private readonly DatatypeInterface $datatype)
    {
    }

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult
    {
        return new ExecutionResult();
    }

    public function v()
    {
       return $this->datatype;
    }

    public function getNames(): array
    {
        return [self::TYPE_DATATYPE];
    }

    public function dumpType(): string
    {
        return self::TYPE_DATATYPE;
    }

    public function realValidate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_DATATYPE, $datatype->getNames(), true), 0);
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new DataReturnLoad($this);
    }
}