<?php

namespace PHell\Operators;

use PHell\Flow\Data\Data\Boolea;
use PHell\Flow\Data\Datatypes\FloatType;
use PHell\Flow\Exceptions\XBiggerEqualsThanYException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class XBiggerEqualsThanY extends EasyStatement
{
    public function __construct(private readonly Statement $x, private readonly Statement $y)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $xRL = $this->x->getValue($currentEnvironment, $exHandler);
        if ($xRL instanceof DataReturnLoad === false) { return $xRL; }
        $yRL = $this->y->getValue($currentEnvironment, $exHandler);
        if ($yRL instanceof DataReturnLoad === false) { return $yRL; }

        $x = $xRL->getData();
        $y = $yRL->getData();

        $floatValidator = new FloatType();
        if ($floatValidator->validate($x)->isSuccess() && $floatValidator->validate($y)->isSuccess()) {
            $return = new Boolea($x->v() >= $y->v());
        } else {
            $exResult = $exHandler->handle(new XBiggerEqualsThanYException([$x, $y]));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exResult->getHandler(), new ExecutionResult())));
        }
        return new DataReturnLoad($return);
    }

}