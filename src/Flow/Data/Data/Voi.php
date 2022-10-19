<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Data\DatatypeValidators\DatatypeValidation;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\ExecutionResult;
use PHell\Flow\Main\ReturnLoad;

class Voi implements DataInterface
{

    public const TYPE_VOID = 'void';

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult
    {
        return new ExecutionResult();
    }

    public function v()
    {
        return null;
    }

    /** @return string[] */
    public function getNames(): array
    {
        return [self::TYPE_VOID, Nil::TYPE_NULL];
    }

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_VOID, $datatype->getNames(), true), 0);
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new ReturnLoad($this);
    }
}