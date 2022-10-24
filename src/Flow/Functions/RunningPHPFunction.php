<?php

namespace PHell\Flow\Functions;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\Boolea;
use PHell\Flow\Data\Data\ClosedResource;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Floa;
use PHell\Flow\Data\Data\Intege;
use PHell\Flow\Data\Data\Nil;
use PHell\Flow\Data\Data\Resource;
use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Functions\Parenthesis\FunctionParenthesis;
use Phell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\ReturnLoad;

class RunningPHPFunction extends EasyStatement
{

    public function __construct(private readonly PHPFunctionContainer $function,
                                private readonly FunctionParenthesis $parenthesis)
    {
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {

        try {
            $result = $this->function->invoke($this->parenthesis);
        } catch (\Throwable $throwable) {
            //TODO do Exception
        }

        return new ReturnLoad(self::convertPHPValue($result));
    }

    public static function convertPHPValue(mixed $value): DataInterface
    {
        if (is_array($value)) {
            // TODO implement
            throw new ShouldntHappenException();
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