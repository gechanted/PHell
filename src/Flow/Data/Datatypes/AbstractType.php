<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\ExecutionResult;

abstract class AbstractType implements DatatypeInterface
{

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return $datatype->isA($this);
    }

    public function isA(DatatypeInterface $datatype): DatatypeValidation
    {
        return $datatype->realValidate($this);
    }

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult
    {
        return new ExecutionResult();
    }


}