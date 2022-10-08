<?php

namespace PHell\Code;

use PHell\Flow\Exception\Exception;

interface CodeExceptionTransmitter
{

    public function transmit(Exception $exception): ExceptionHandlingResult;
}