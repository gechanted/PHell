<?php

namespace PHell\Operators;

use PHell\Flow\Data\Data\Floa;
use PHell\Flow\Data\Data\Intege;
use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Data\Datatypes\FloatType;
use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Data\Datatypes\StringType;
use PHell\Flow\Exceptions\MinusException;
use PHell\Flow\Exceptions\MultiplyException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class Multiply extends EasyStatement
{
    public function __construct(private readonly Statement $times, private readonly Statement $baselineValue)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $timesRL = $this->times->getValue($currentEnvironment, $exHandler);
        if ($timesRL instanceof DataReturnLoad === false) { return $timesRL; }
        $baselineValueRL = $this->baselineValue->getValue($currentEnvironment, $exHandler);
        if ($baselineValueRL instanceof DataReturnLoad === false) { return $baselineValueRL; }

        $times = $timesRL->getData();
        $baseline = $baselineValueRL->getData();

        $stringValidator = new StringType();
        $floatValidator = new FloatType();
        $intValidator = new IntegerType();

        if ($stringValidator->validate($baseline)->isSuccess() && $intValidator->validate($times)->isSuccess()) {
            $string = '';
            for ($i = 0; $i < $times->v(); $i++) {
                $string .= $baseline->v();
            }
            $return = new Strin($string);

        } elseif ($intValidator->validate($times)->isSuccess() && $intValidator->validate($baseline)->isSuccess()) {
            $return = new Intege($times->v() - $baseline->v());
        } elseif ($floatValidator->validate($times)->isSuccess() && $floatValidator->validate($baseline)->isSuccess()) {
            $return = new Floa($times->v() - $baseline->v());
        } else {
            $exResult = $exHandler->handle(new MultiplyException([$times, $baseline]));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exResult->getHandler(), new ExecutionResult())));
        }
        return new DataReturnLoad($return);
    }

}