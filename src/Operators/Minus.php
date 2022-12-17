<?php

namespace PHell\Operators;

use PHell\Flow\Data\Data\Floa;
use PHell\Flow\Data\Data\Intege;
use PHell\Flow\Data\Datatypes\FloatType;
use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Exceptions\MinusException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class Minus extends EasyStatement
{
    public function __construct(private readonly Statement $baselineValue, private readonly Statement $subtractor)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $baselineValueRL = $this->baselineValue->getValue($currentEnvironment, $exHandler);
        if ($baselineValueRL instanceof DataReturnLoad === false) { return $baselineValueRL; }
        $subtractorRL = $this->subtractor->getValue($currentEnvironment, $exHandler);
        if ($subtractorRL instanceof DataReturnLoad === false) { return $subtractorRL; }

        $baselineValue = $baselineValueRL->getData();
        $subtractor = $subtractorRL->getData();

        $floatValidator = new FloatType();
        $intValidator = new IntegerType();

        if ($intValidator->validate($baselineValue)->isSuccess() && $intValidator->validate($subtractor)->isSuccess()) {
            $return = new Intege($baselineValue->v() - $subtractor->v());
        } elseif ($floatValidator->validate($baselineValue)->isSuccess() && $floatValidator->validate($subtractor)->isSuccess()) {
            $return = new Floa($baselineValue->v() - $subtractor->v());
        } else {
            $exResult = $exHandler->handle(new MinusException([$baselineValue, $subtractor]));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exResult->getHandler(), new ExecutionResult())));
        }
        return new DataReturnLoad($return);
    }
}