<?php

namespace PHell\Flow\Data\Data;

use PHell\Exceptions\ExceptionInPHell;
use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\UnexecutedFunctionCollectionType;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\FunctionResolver;
use PHell\Flow\Functions\LambdaFunction;
use PHell\Flow\Functions\PHPLambdaFunction;
use PHell\Flow\Functions\PHPObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\RunningPHPFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\ExceptionEndHandler;
use PHell\Flow\Main\Returns\CatapultReturnLoad;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionHandlingResult;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Operators\ExecuteFunction;
use PHell\PHell;
use PHell\Tests\Ops\FakeRunningFunction;

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

    /** @return LambdaFunction[] */
    public function phpV(): array
    {
        return $this->v();
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        $dump = '';
        $name = 'no name';
        foreach ($this->lambdaFunctions as $key => $function) {
            $name = $function->getName();
            $dump .= $key . ' => (' . $function->dumpParenthesis() . '):' . $function->getParenthesis()->getReturnType()->dumpType() . PHP_EOL;
        }
        return self::TYPE_LAMBDA . '(' . $name . ')[' . $dump . ']';
    }

    /**
     * @param ...$args
     * @return mixed
     * @throws ExceptionInPHell
     */
    public function __invoke(...$args)
    {
        $phellParams = [];
        foreach ($args as $param) {
            $phellParams[] = RunningPHPFunction::convertPHPValue($param);
        }
        $executor = new ExecuteFunction($this, $phellParams);
        $value = $executor->getValue(new FakeRunningFunction(), new ExceptionEndHandler());
        if ($value instanceof DataReturnLoad) {
            return $value->getData()->phpV();
        } elseif ($value instanceof CatapultReturnLoad) {
            trigger_error('Cannot catapult over php code');
            return $value->getData()->phpV();
        } elseif ($value instanceof ExceptionReturnLoad) {
            throw new ExceptionInPHell($value);
        } else {
            throw new ShouldntHappenException();
        }
    }
}