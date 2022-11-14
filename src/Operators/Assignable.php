<?php

namespace PHell\Operators;

use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

interface Assignable extends Statement
{
    public function set(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper, ?DataInterface $value): ReturnLoad;
}