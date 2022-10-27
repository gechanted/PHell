<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\DatatypeInterface;
use PHell\Flow\Data\DatatypeValidators\DatatypeValidation;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\LambdaFunction;
use PHell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

/** The ACTUAL Lambda Function */
class UnexecutedFunctionCollection implements DataInterface
{

    public const TYPE_LAMBDA = 'lambda';

    /** @param LambdaFunction[] $lambdaFunctions */
    public function __construct(private readonly array $lambdaFunctions)
    {
    }

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult
    {
        return new ExecutionResult();
    }

    /** @return LambdaFunction[] */
    public function v(): array
    {
        return $this->lambdaFunctions;
    }

    public function getNames(): array
    {
        return [self::TYPE_LAMBDA];
    }

    public function validate(DatatypeInterface $datatype): DatatypeValidation
    {
        return new DatatypeValidation(in_array(self::TYPE_LAMBDA, $datatype->getNames(), true), 0);
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new DataReturnLoad($this);
    }
}