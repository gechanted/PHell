<?php

namespace PHell\Flow\Main;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Exceptions\Exception;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;

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
        $return = $this->getValue($currentEnvironment, $upper);
        return new ExecutionResult($return->isExceptionReturn() ? new ReturningExceptionAction() : null);
    }

    abstract public function value(FunctionObject $currentEnvironment): ReturnLoad;

     public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad
     {
         $this->upper = $upper;
         return $this->value($currentEnvironment);
     }
 }