<?php

namespace PHell\Flow\Exceptions;

class OverShoveException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(__CLASS__, 'Cannot Shove over a Function');
    }

}