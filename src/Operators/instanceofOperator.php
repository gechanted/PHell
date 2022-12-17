<?php

namespace PHell\Operators;

use PHell\Flow\Data\Data\Boolea;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class instanceofOperator extends EasyStatement
{

    public function __construct(private readonly Statement $toBeEvaluated, private readonly Statement $validator)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $validatorRL = $this->validator->getValue($currentEnvironment, $exHandler);
        if ($validatorRL instanceof DataReturnLoad === false) { return $validatorRL; }
        $validator = $validatorRL->getData();

        $evaluatedRL = $this->toBeEvaluated->getValue($currentEnvironment, $exHandler);
        if ($evaluatedRL instanceof DataReturnLoad === false) { return $evaluatedRL; }
        $evaluated = $evaluatedRL->getData();

        return new DataReturnLoad(new Boolea($validator->validate($evaluated)->isSuccess()));
    }
}