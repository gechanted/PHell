<?php
namespace PHell\Code;

use PHell\Flow\Functions\FunctionObject;

interface Statement extends Command
{

    public function getValue(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper): ReturnLoad;

//    public function execute(FunctionObject $currentEnvironment, Statement $upper)
//    {
//        $this->getValue($currentEnvironment, $upper);
//    }

}