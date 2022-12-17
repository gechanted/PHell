<?php

namespace PHell\Operators;

use PHell\Flow\Data\Data\Boolea;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class Equals extends EasyStatement
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

        $return = new Boolea($x->v() === $y->v());
        return new DataReturnLoad($return);
    }

}