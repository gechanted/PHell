<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Data\DatatypeValidators\DatatypeValidation;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class Resource implements DataInterface
{
    public const TYPE_RESOURCE = 'resource';

    public function __construct(private $resource)
    {
    }

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult
    {
        return new ExecutionResult();
    }

    public function v()
    {
        return $this->resource;
    }

    public function getNames(): array
    {
        return [self::TYPE_RESOURCE];
    }

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_RESOURCE, $datatype->getNames(), true), 0);
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new DataReturnLoad($this);
    }
}