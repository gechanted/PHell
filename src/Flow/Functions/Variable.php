<?php

namespace PHell\Flow\Functions;

use PHell\Code\Statement;

class Variable implements Statement
{

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getValue()
    {

    }
}