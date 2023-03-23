<?php

namespace PHell\Operators;

use PHell\Flow\Data\Data\Floa;
use PHell\Flow\Data\Data\Intege;
use PHell\Flow\Data\Datatypes\FloatType;
use PHell\Flow\Exceptions\DivideByZeroException;
use PHell\Flow\Exceptions\DivideException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class Divide extends EasyStatement
{
    public function __construct(private readonly Statement $baselineValue, private readonly Statement $by)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $baselineValueRL = $this->baselineValue->getValue($currentEnvironment, $exHandler);
        if ($baselineValueRL instanceof DataReturnLoad === false) { return $baselineValueRL; }
        $byRL = $this->by->getValue($currentEnvironment, $exHandler);
        if ($byRL instanceof DataReturnLoad === false) { return $byRL; }

        $baselineValue = $baselineValueRL->getData();
        $by = $byRL->getData();

        $floatValidator = new FloatType();
        if ($floatValidator->validate($baselineValue)->isSuccess() && $floatValidator->validate($by)->isSuccess()) {
            if ($by->v() === 0) {
                $exResult = $exHandler->handle(new DivideByZeroException());
                return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exResult->getHandler(), new ExecutionResult())));
            }
            $result = $baselineValue->v() / $by->v();
            if (is_int($result)) {
                $return = new Intege($result);
            } else {
                $return = new Floa($result);
            }
            //TODO new operator specialization : $object / $sth = $object->divideoperatoring
        } else {
            $exResult = $exHandler->handle(new DivideException([$baselineValue, $by]));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exResult->getHandler(), new ExecutionResult())));
        }
        return new DataReturnLoad($return);
    }

}