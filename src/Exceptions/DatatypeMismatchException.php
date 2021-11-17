<?php

namespace PHell\Exceptions;

use Throwable;

class DatatypeMismatchException extends AbstractException
{
    public function __construct($object, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($object, $code, $previous);
    }
}