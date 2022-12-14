<?php

namespace PHell\Flow\Functions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\Arra;
use PHell\Flow\Data\Data\Boolea;
use PHell\Flow\Data\Data\ClosedResource;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Floa;
use PHell\Flow\Data\Data\Intege;
use PHell\Flow\Data\Data\Nil;
use PHell\Flow\Data\Data\Resource;
use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Data\Data\UnexecutedFunctionCollection;
use PHell\Flow\Exceptions\PHPException;
use PHell\Flow\Functions\Parenthesis\DataFunctionParenthesis;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use ReflectionFunction;

class RunningPHPFunction extends EasyStatement
{

    public function __construct(private readonly PHPFunctionContainer    $function,
                                private readonly DataFunctionParenthesis $parenthesis)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {

        try {
            $result = $this->function->invoke($this->parenthesis);
        } catch (\Throwable $throwable) {
            $r = $exHandler->handle(new PHPException($throwable));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
        }

        return new DataReturnLoad(self::convertPHPValue($result));
    }

    public static function convertPHPValue(mixed $value): DataInterface
    {
        if ($value instanceof DataInterface) {
            //is something send from PHP for usage here
            return $value;
        } elseif (is_array($value)) {
            $array = new Arra([]);
            foreach ($value as $key => $item) {
                $pHellItem = self::convertPHPValue($item);
                $pHellKey = self::convertPHPValue($key);
                $array->set($pHellItem, $pHellKey);
            }
            return $array;
        } elseif (is_callable($value)) {
            $reflection = new ReflectionFunction($value);
            return new UnexecutedFunctionCollection([new PHPLambdaFunction(new PHPFunction($reflection))]);
        } elseif (is_bool($value)) {
            return new Boolea($value);
        } elseif (is_int($value)) {
            return new Intege($value);
        } elseif (is_string($value)) {
            return new Strin($value);
        } elseif (is_float($value)) {
            return new Floa($value);
        } elseif (is_object($value)) {
            return new PHPObject($value);
        } elseif (is_null($value)) {
            return new Nil();
        } elseif (is_resource($value)) {
            return new Resource($value);
        } else {
            //a closed resource??
            return new ClosedResource($value);
        }
    }
}