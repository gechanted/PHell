<?php
namespace PHell\Flow\Main;

use PHell\Flow\Functions\FunctionObject;

interface Statement extends Command
{
    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad;
}