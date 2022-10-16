<?php

namespace PHell\Flow\Main;

use PHell\Flow\Exceptions\Exception;

interface CodeExceptionTransmitter
{

    public function transmit(Exception $exception): ExceptionHandlingResult;
}