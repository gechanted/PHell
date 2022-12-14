<?php

namespace PHell\Exceptions;

use PHell\Flow\Main\Returns\ExceptionReturnLoad;

class ExceptionInPHell extends PHellException
{

    public function __construct(ExceptionReturnLoad $exceptionReturnLoad)
    {
        //TODO maybe use $exception Returnload to explain better
        parent::__construct('An Exception was thrown in the PHell called Code');
    }

}