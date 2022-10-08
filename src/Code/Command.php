<?php

namespace PHell\Code;

use PHell\Flow\Functions\FunctionObject;

interface Command
{

    public function execute(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper);
}