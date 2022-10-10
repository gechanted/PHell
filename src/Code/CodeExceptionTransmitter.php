<?php

namespace PHell\Code;

use PHell\Flow\Exceptions\Exception;

interface CodeExceptionTransmitter
{

    public function transmit(Exception $exception): ExceptionHandlingResult;
}