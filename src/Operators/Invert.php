<?php

namespace PHell\Operators;

use PHell\Flow\Data\Data\Boolea;
use PHell\Flow\Data\Datatypes\BooleanType;
use PHell\Flow\Exceptions\InvertException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class Invert extends EasyStatement
{
    public function __construct(private readonly Statement $bool)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $boolRL = $this->bool->getValue($currentEnvironment, $exHandler);
        if ($boolRL instanceof DataReturnLoad === false) { return $boolRL; }

        $bool = $boolRL->getData();

        $validator = new BooleanType();
        if ($validator->validate($bool)->isSuccess()) {
            $return = new Boolea(!$bool->v());
        } else {
            $exResult = $exHandler->handle(new InvertException([$bool]));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exResult->getHandler(), new ExecutionResult())));
        }
        return new DataReturnLoad($return);
    }

}