<?php
namespace PHell\Flow\Main;

use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\Returns\ReturnLoad;

interface Statement extends Command
{
    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad;
}