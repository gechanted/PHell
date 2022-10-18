<?php

namespace PHell\Flow\Exceptions;

use PHell\Flow\Functions\FunctionObject;

class Exception extends FunctionObject
{

    public function __construct(string $name, string $msg)
    {
        parent::__construct($name, null, null, null);
        // TODO !!! variable $msg hinzufügen
    }
}