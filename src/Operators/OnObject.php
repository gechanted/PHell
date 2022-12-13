<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Exceptions\CallOnNotObjectException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
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

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        $returnLoad = $this->object->getValue($currentEnvironment, $exHandler);
        if ($returnLoad instanceof DataReturnLoad === false) { return $returnLoad; }
        $object = $returnLoad->getData();
        if ($object instanceof FunctionObject === false) {
            $exResult = $exHandler->handle(new CallOnNotObjectException($object));
            return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($exResult->getHandler(), new ExecutionResult())));
        }

        if ($object === $currentEnvironment) {
            $this->furtherCall->changeScope(ScopeAffected::SCOPE_THIS_OBJECT_CALL);
        } else {
            $this->furtherCall->changeScope($object);
        }

        return $this->furtherCall->getValue($currentEnvironment, $exHandler);
    }

    public function set(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler, ?DataInterface $value): ReturnLoad
    {
        return $this->furtherCall->set($currentEnvironment, $exHandler, $value);
    }
}