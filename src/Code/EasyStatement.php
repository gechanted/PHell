<?php

namespace PHell\Code;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Exceptions\Exception;
use PHell\Flow\Functions\FunctionObject;

 abstract class EasyStatement implements Command, CodeExceptionTransmitter, Statement
{

    protected CodeExceptionTransmitter $upper;

    public function transmit(Exception $exception): ExceptionHandlingResult
    {
        if ($this->upper === null) {
            throw new ShouldntHappenException();
        }
        return $this->upper->transmit($exception);
    }
    
    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ExecutionResult
    {
        $this->getValue($currentEnvironment, $upper);
        return new ExecutionResult(false, null);
    }

    abstract public function value(FunctionObject $currentEnvironment): ReturnLoad;

     public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
     {
         $this->upper = $upper;
         return $this->value($currentEnvironment);
     }
 }