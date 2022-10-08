<?php

namespace PHell\Code;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Exception\Exception;
use PHell\Flow\Functions\FunctionObject;

abstract class EasyCommand implements Command, CodeExceptionTransmitter
{

    protected CodeExceptionTransmitter $upper;

    public function transmit(Exception $exception): ExceptionHandlingResult
    {
        if ($this->upper === null) {
            throw new ShouldntHappenException();
        }
        return $this->upper->transmit($exception);
    }
    
    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper)
    {
        $this->upper = $upper;
        $this->exec($currentEnvironment);
    }

    abstract public function exec(FunctionObject $currentEnvironment);

}