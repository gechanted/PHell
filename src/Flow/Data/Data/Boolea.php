<?php
namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\BooleanType;
use PHell\Flow\Functions\RunningFunction;
use Phell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

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

    public function v()
    {
        return $this->value;
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return $this->value ? 'TRUE' : 'FALSE';
    }
}