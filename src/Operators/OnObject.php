<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\CodeExceptionTransmitter;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

/**
 *  . or  ->
 * the OnObject just changes the scope of the following
 */
class OnObject extends EasyStatement implements Assignable
{
    public function __construct(private readonly Statement $object, private readonly Assignable|ScopeAffected|Statement $furtherCall)
    {
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        $returnLoad = $this->object->getValue($currentEnvironment, $this->upper);
        if ($returnLoad instanceof ExceptionReturnLoad) { return $returnLoad; }
        if ($returnLoad instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }
        $object = $returnLoad->getData();
        //TODO !!! add check if this actually returns a FunctionObject, cause you cant "null->f(x)" / call a function on a basic datatype

        if ($object === $currentEnvironment) {
            $this->furtherCall->changeScope(ScopeAffected::SCOPE_THIS_OBJECT_CALL);
        } else {
            $this->furtherCall->changeScope($object);
        }

        return $this->furtherCall->getValue($currentEnvironment, $this->upper);
    }

    public function set(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper, ?DataInterface $value): ReturnLoad
    {
        return $this->furtherCall->set($currentEnvironment, $upper, $value);
    }
}