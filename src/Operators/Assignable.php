<?php

namespace PHell\Operators;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

interface Assignable extends Statement
{
    public function set(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler, ?DataInterface $value): ReturnLoad;
}