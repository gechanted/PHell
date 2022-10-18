<?php
namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\BooleanType;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\ExecutionResult;
use PHell\Flow\Main\ReturnLoad;

class Boolea extends BooleanType implements DataInterface
{
    public function __construct(private readonly bool $value)
    {
    }

    public function getBool(): bool
    {
        return $this->value;
    }

    public static function n(bool $v): self
    {
        return new self($v);
    }

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult
    {
        return new ExecutionResult();
    }

    public function v()
    {
        return $this->value;
    }

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
    {
        return new ReturnLoad($this);
    }
}