<?php

namespace PHell\Flow\Exceptions;

class NoOverloadFunctionException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('NoOverloadFunctionException', 'No useable function for given in Parameters');
        //TODO add details / add all function parenthesis (with types) and given parameter types
    }
}