<?php

namespace PHell\Flow\Data\Data;

use PHell\Exceptions\ExceptionInPHell;
use PHell\Exceptions\PHellCallableResolveExceptionMultipleMatches;
use PHell\Exceptions\PHellCallableResolveExceptionNoMatches;
use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\UnexecutedFunctionCollectionType;
use PHell\Flow\Data\Datatypes\UnknownDatatype;
use PHell\Flow\Exceptions\AmbiguousOverloadFunctionCallException;
use PHell\Flow\Exceptions\NoOverloadFunctionException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\FunctionResolver;
use PHell\Flow\Functions\LambdaFunction;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesisParameter;
use PHell\Flow\Functions\PHPLambdaFunction;
use PHell\Flow\Functions\PHPObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\RunningPHPFunction;
use PHell\Flow\Functions\StandardFunctions\Dump;
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

class UnexecutedFunctionCollection extends UnexecutedFunctionCollectionType implements DataInterface, CodeExceptionHandler
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

    public function __toString(): string
    {
        return Dump::dump($this);
    }

    /**
     * @param ...$args
     * @return mixed
     * @throws PHellCallableResolveExceptionMultipleMatches
     * @throws PHellCallableResolveExceptionNoMatches
     * @throws \Throwable
     */
    public function __invoke(...$args)
    {
        $parenthesis = new DataFunctionParenthesis([], new UnknownDatatype());
        foreach ($args as $param) {
            $parenthesis->addParameter(new DataFunctionParenthesisParameter(RunningPHPFunction::convertPHPValue($param)));
        }
        $lambda = FunctionResolver::resolve($parenthesis, $this, $this);
        $phell = new PHell();
        return $phell->execute($lambda->getCode());
    }

    public function handle(FunctionObject $exception): ExceptionHandlingResult
    {
        if ($exception instanceof NoOverloadFunctionException) {
            throw new PHellCallableResolveExceptionNoMatches($exception);
        } elseif ($exception instanceof AmbiguousOverloadFunctionCallException) {
            throw new PHellCallableResolveExceptionMultipleMatches($exception);
        } else {
            throw new ShouldntHappenException();
        }
    }
}