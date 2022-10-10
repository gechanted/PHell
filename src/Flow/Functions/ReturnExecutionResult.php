<?php

namespace PHell\Flow\Functions;

class ReturnExecutionResult
{

    //TODO add parameter for catapult returning
    public function __construct(private $value)
    {
    }

    public function getValue()
    {
        return $this->value;
    }
}