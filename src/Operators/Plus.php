<?php
namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\Floa;
use PHell\Flow\Data\Data\Intege;
use PHell\Flow\Data\Data\Strin;
use PHell\Flow\Data\DatatypeValidators\FloatTypeValidator;
use PHell\Flow\Data\DatatypeValidators\IntegerTypeValidator;
use PHell\Flow\Data\DatatypeValidators\StringTypeValidator;
use PHell\Flow\Exceptions\PlusException;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use Phell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;
use Phell\Flow\Main\Statement;

class Plus extends EasyStatement
{
    private Statement $s1;
    private Statement $s2;

    public function __construct(Statement $s1, Statement $s2)
    {
        $this->s1 = $s1;
        $this->s2 = $s2;
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        $r1 = $this->s1->getValue($currentEnvironment, $this->upper);
        if ($r1 instanceof ExceptionReturnLoad) { return $r1; }
        $r2 = $this->s2->getValue($currentEnvironment, $this->upper);
        if ($r2 instanceof ExceptionReturnLoad) { return $r2; }
        if ($r1 instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }
        if ($r2 instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }

        $v1 = $r1->getData();
        $v2 = $r2->getData();

        $intValidator = new IntegerTypeValidator();
        $floatValidator = new FloatTypeValidator();
        $stringValidator = new StringTypeValidator();
        if ($intValidator->validate($v1) && $intValidator->validate($v2)) {
            $return = new Intege($v1->v() + $v2->v());

        } elseif ($floatValidator->validate($v1) && $floatValidator->validate($v2)) {
            $return = new Floa($v1->v() + $v2->v());

        } elseif ($stringValidator->validate($v1) && $stringValidator->validate($v2)) {
            $return = new Strin($v1->v() . $v2->v());

        } else {
            $r = $this->upper->transmit(new PlusException([$v1, $v2]));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
            //nothing i can deal with
        }

        return new DataReturnLoad($return);
    }

}