<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\ReturnLoad;
use Phell\Flow\Main\Statement;

class Dump extends EasyStatement
{

    public function __construct(private readonly Statement $statement)
    {
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        $load = $this->statement->getValue($currentEnvironment, $this->upper);
//        if ($load->isExceptionReturn()) {
//            return new ExceptionReturnLoad();
//        }

        //TODO do
//        $load->getData();
    }
}