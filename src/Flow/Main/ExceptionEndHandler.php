<?php

namespace PHell\Flow\Main;

use Monolog\Logger;
use PHell\Flow\Data\Data\Voi;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\StandardFunctions\Dump;
use PHell\Flow\Main\Returns\ExceptionHandlingResult;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use PHell\Flow\Main\Returns\ExecutionResult;

class ExceptionEndHandler implements CodeExceptionHandler
{

    public function __construct(private readonly Logger $logger)
    {
    }

    public function handle(FunctionObject $exception): ExceptionHandlingResult
    {
        $msg = Dump::dump($exception);
        $this->logger->alert($msg);
        if ($exception->getNormalVar('crash')->v() === false) {
            //exception has crash var, which is bool and false
            return new ExceptionHandlingResultShove($this, new Voi());
            //TODO ! test
        }
        return new ExceptionHandlingResultNoShove($this, new ExecutionResult());
    }
}