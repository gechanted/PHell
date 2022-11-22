<?php

namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\UnexecutedFunctionCollectionType;
use PHell\Flow\Functions\LambdaFunction;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class UnexecutedFunctionCollection extends UnexecutedFunctionCollectionType implements DataInterface
{
    /** @param LambdaFunction[] $lambdaFunctions */
    public function __construct(private readonly array $lambdaFunctions)
    {
    }

    /** @return LambdaFunction[] */
    public function v(): array
    {
        return $this->lambdaFunctions;
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        $dump = '';
        foreach ($this->lambdaFunctions as $key => $function) {
            $dump .= $key.' => ('.$function->dumpParenthesis().'):'.$function->getParenthesis()->getReturnType()->dumpType().PHP_EOL;
        }
        return self::TYPE_LAMBDA.'('.$function->getName().')['.$dump.']';
    }
}