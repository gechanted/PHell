<?php

namespace PHell\Flow\Exceptions;

class DivideByZeroException extends RuntimeException
{

    public function __construct()
    {
        parent::__construct('DivideByZeroException', 'NO, you cant divide by 0. I havent implemented Infinty yet');
    }
}