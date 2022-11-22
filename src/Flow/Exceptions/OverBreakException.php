<?php

namespace PHell\Flow\Exceptions;

class OverBreakException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(__CLASS__, 'Cannot Break over a Function');
    }
}