<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Data\DatatypeValidators\DatatypeValidation;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class Nil implements DataInterface
{

    public const TYPE_NULL = 'null';

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
        return [self::TYPE_NULL];
    }

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        $counter = 0;
        foreach ($datatype->getNames() as $typeName) {
            if ($typeName === self::TYPE_NULL){
                return new DatatypeValidation(true, $counter);
            }
            $counter++;
        }
        return new DatatypeValidation(false, 0);
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

}