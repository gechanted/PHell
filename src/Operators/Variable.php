<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Undefined;
use PHell\Flow\Exceptions\CannotChangeForeignObjectException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\CodeExceptionTransmitter;
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

    public function changeVisibility(string $visibility)
    {
        $this->visibility = $visibility;
    }



    public function __construct(private readonly string $name)
    {
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        switch ($this->scope) {
            case self::SCOPE_INNER_OBJECT:
                $value = $currentEnvironment->getNormalVar($this->name);
                if ($value === null) {
                    $this->set($currentEnvironment, $this->upper, new Undefined());
                }
                break;
            case self::SCOPE_THIS_OBJECT_CALL:
                $value = $currentEnvironment->getPublicAndProtectedVariable($this->name);
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


    public function set(FunctionObject $currentEnvironment, CodeExceptionTransmitter $upper, ?DataInterface $value): ReturnLoad
    {
        switch ($this->scope) {

            case self::SCOPE_INNER_OBJECT:
                $currentEnvironment->setNormalVar($this->name, $value, $this->visibility);
                break;

            case self::SCOPE_THIS_OBJECT_CALL:
                //if a visibility was used before I tell them to fuck off
                //cause this shit shouldnt be ....
                //basicly only use visibility only when normally declaring
                //otherwise computer says no
                if ($this->visibility !== FunctionObject::VISIBILITY_PRIVATE) {
                    $r = $upper->transmit(new CannotChangeForeignObjectException());
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
                }
                $currentEnvironment->setPublicAndProtectedVariable($this->name, $value);
                break;

            default: //case self::SCOPE_FOREIGN_OBJECT_CALL
                if ($this->visibility !== FunctionObject::VISIBILITY_PRIVATE) {
                    $r = $upper->transmit(new CannotChangeForeignObjectException());
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
                }

                $this->scope->setObjectOuterVar($this->name, $value);
        }

        return new DataReturnLoad($value);
    }


}