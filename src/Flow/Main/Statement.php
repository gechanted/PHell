<?php
namespace PHell\Flow\Main;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\Returns\ReturnLoad;

interface Statement extends Command
{
    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad;
}