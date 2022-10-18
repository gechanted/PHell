<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\ExceptionReturnLoad;
use PHell\Flow\Main\ReturnLoad;
use PHell\Flow\Main\Statement;

class Dump extends EasyStatement
{

    public function __construct(private readonly Statement $statement)
    {
    }

    public function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        $load = $this->statement->getValue($currentEnvironment, $this->upper);
        if ($load->isExceptionReturn()) {
            return new ExceptionReturnLoad();
        }

        //TODO do
        $load->getData();
    }
}