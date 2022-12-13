<?php

namespace PHell\Flow\Main;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\Returns\ExceptionHandlingResult;

class ExceptionEndHandler implements CodeExceptionHandler
{

    public function handle(FunctionObject $exception): ExceptionHandlingResult
    {
        //decision: crash, no crash
        //log into certain log
        //on crash
        //   send back and return a string
        //
        // TODO: Implement handle() method.
    }
}