<?php

namespace PHell\Flow\Exceptions;

class OverContinueException extends Exception
{

    public function __construct()
    {
        parent::__construct(__CLASS__, 'Cannot Continue over a Function');
    }
}