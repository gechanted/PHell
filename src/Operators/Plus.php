<?php
namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\Floa;
use PHell\Flow\Data\Data\Intege;
use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Data\Datatypes\FloatType;
use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Data\Datatypes\StringType;
use PHell\Flow\Exceptions\PlusException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class Plus extends EasyStatement
{
    private Statement $s1;
    private Statement $s2;

    public function __construct(Statement $s1, Statement $s2)
    {
        $this->s1 = $s1;
        $this->s2 = $s2;
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $rl1 = $this->s1->getValue($currentEnvironment, $exHandler);
        if ($rl1 instanceof DataReturnLoad === false) { return $rl1; }
        $rl2 = $this->s2->getValue($currentEnvironment, $exHandler);
        if ($rl2 instanceof DataReturnLoad === false) { return $rl2; }

        $v1 = $rl1->getData();
        $v2 = $rl2->getData();

        $intValidator = new IntegerType();
        $floatValidator = new FloatType();
        $stringValidator = new StringType();
        if ($intValidator->validate($v1) && $intValidator->validate($v2)) {
            $return = new Intege($v1->v() + $v2->v());

        } elseif ($floatValidator->validate($v1) && $floatValidator->validate($v2)) {
            $return = new Floa($v1->v() + $v2->v());

        } elseif ($stringValidator->validate($v1) && $stringValidator->validate($v2)) {
            $return = new Strin($v1->v() . $v2->v());

        } else {
            $r = $exHandler->handle(new PlusException([$v1, $v2]));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
            //nothing (not a type) I can deal with currently
            //TODO maybe add certain custom functionality for this operator,
            // so that certain Objects can be added
        }

        return new DataReturnLoad($return);
    }

}