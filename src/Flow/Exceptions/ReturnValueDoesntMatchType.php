<?php

namespace PHell\Flow\Exceptions;

class ReturnValueDoesntMatchType extends DataTypeMismatchException
{

    public function __construct()
    {
        parent::__construct('ReturnValueDoesntMatchType', 'The return value of this function is not valid');
    }
}