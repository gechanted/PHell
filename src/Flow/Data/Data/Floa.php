<?php
namespace PHell\Flow\Data\Data;

use PHell\Flow\Data\Datatypes\FloatType;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class Floa extends FloatType implements DataInterface
{

    public function __construct(private readonly float $value)
    {
    }

    public function v(): float
    {
        return $this->value;
    }

    public function phpV(): float
    {
        return $this->v();
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        return new DataReturnLoad($this);
    }

    public function dumpValue(): string
    {
        return self::removeTrailingZeros(number_format($this->value, 13));
    }

    private static function removeTrailingZeros(string $number): string
    {
        while (true) {
            if (str_ends_with($number, '0')) {
                $number = substr($number, 0, strlen($number)-1);
            } else {
                break;
            }
        }
        if (str_ends_with($number, '.')) {
            $number .= '0';
        }
        return $number;
    }

    public function __toString(): string
    {
        return Dump::dump($this);
    }
}