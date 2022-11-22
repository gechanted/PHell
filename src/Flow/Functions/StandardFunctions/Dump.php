<?php

namespace PHell\Flow\Functions\StandardFunctions;

use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
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
        if ($load instanceof DataReturnLoad === false) { return $load; }

        return new DataReturnLoad(new Strin($load->getData()->dumpValue()));
    }
}