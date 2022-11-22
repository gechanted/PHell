<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Undefined;
use PHell\Flow\Exceptions\CannotChangeForeignObjectException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class Variable extends EasyStatement implements ScopeAffected, VisibilityAffected, Assignable
{

    private string|FunctionObject $scope = self::SCOPE_INNER_OBJECT;

    private string $visibility = FunctionObject::VISIBILITY_PRIVATE;

    public function changeScope(string|FunctionObject $scope): void
    {
        $this->scope = $scope;
    }

    public function changeVisibility(string $visibility): void
    {
        $this->visibility = $visibility;
    }



    public function __construct(private readonly string $name)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        switch ($this->scope) {
            case self::SCOPE_INNER_OBJECT:
                $value = $currentEnvironment->getObject()->getNormalVar($this->name);
                if ($value === null) {
                    $this->set($currentEnvironment, $exHandler, new Undefined());
                }
                break;
            case self::SCOPE_THIS_OBJECT_CALL:
                $value = $currentEnvironment->getObject()->getPublicAndProtectedVariable($this->name);
                break;
            default:
                if ($this->scope instanceof FunctionObject === false) {
                    throw new ShouldntHappenException();
                }
                $value = $this->scope->getObjectPubliclyAvailableVar($this->name);
        }
        if ($value === null) {
            $value = new Undefined();
        }

        return new DataReturnLoad($value);
    }


    public function set(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler, ?DataInterface $value): ReturnLoad
    {
        switch ($this->scope) {

            case self::SCOPE_INNER_OBJECT:
                $currentEnvironment->getObject()->setNormalVar($this->name, $value, $this->visibility);
                break;

            case self::SCOPE_THIS_OBJECT_CALL:
                //if a visibility was used before I tell them to fuck off
                //cause this shit shouldnt be ....
                //basicly only use visibility only when normally declaring
                //otherwise computer says no
                if ($this->visibility !== FunctionObject::VISIBILITY_PRIVATE) {
                    $r = $exHandler->transmit(new CannotChangeForeignObjectException());
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
                }
                $currentEnvironment->getObject()->setPublicAndProtectedVariable($this->name, $value);
                break;

            default: //case self::SCOPE_FOREIGN_OBJECT_CALL
                if ($this->visibility !== FunctionObject::VISIBILITY_PRIVATE) {
                    $r = $exHandler->transmit(new CannotChangeForeignObjectException());
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
                }

                $this->scope->setObjectOuterVar($this->name, $value);
        }

        return new DataReturnLoad($value);
    }


}