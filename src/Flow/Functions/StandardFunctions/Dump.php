<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use Phell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
use Phell\Flow\Main\Statement;

class Dump extends EasyStatement
{

    public function __construct(private readonly Statement $statement)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $load = $this->statement->getValue($currentEnvironment, $exHandler);
        if ($load instanceof DataReturnLoad === false) { return $load; }

        //TODO build an automatic indentor:
        // if { or [ indent++
        // if } or ] indent--
        // watch out for strings
        // if/after PHP_EOL insert whitespaces amounting to the indent

        return new DataReturnLoad(new Strin($load->getData()->dumpValue()));
    }
}