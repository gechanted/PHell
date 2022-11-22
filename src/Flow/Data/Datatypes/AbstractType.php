<?php

namespace PHell\Flow\Data\Datatypes;

use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
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

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        return new ExecutionResult();
    }


}