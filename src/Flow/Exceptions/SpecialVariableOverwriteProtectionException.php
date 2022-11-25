<?php

namespace PHell\Flow\Exceptions;

class SpecialVariableOverwriteProtectionException extends RuntimeException
{

    public function __construct()
    {
        parent::__construct('SpecialVariableOverwriteProtectionException',
            'Cannot change the variables called: "this", "origin", "runningfunction". If you really want to do that: program your own language');
    }
}