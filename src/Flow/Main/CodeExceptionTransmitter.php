<?php

namespace PHell\Flow\Main;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\Returns\ExceptionHandlingResult;

interface CodeExceptionTransmitter
{

    public function transmit(FunctionObject $exception): ExceptionHandlingResult;
}