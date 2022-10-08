<?php

namespace PHell\Flow\Functions;

use PHell\Code\Code;
use PHell\Code\EasyStatement;

class RunningFunction extends EasyStatement
{

    public function __construct(private readonly FunctionObject $object, private readonly Code $code)
    {
    }

    public function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        foreach ($this->code->getStatements() as $statement) {
            $statement->execute($currentEnvironment, $this->upper);
        }
    }
}