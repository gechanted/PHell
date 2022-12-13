<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\RunningFunctionData;
use PHell\Flow\Data\Data\Undefined;
use PHell\Flow\Exceptions\CannotChangeForeignObjectException;
use PHell\Flow\Exceptions\SpecialVariableOverwriteProtectionException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Returns\ReturnLoad;

class Variable extends EasyStatement implements ScopeAffected, VisibilityAffected, Assignable
{

    public const SPECIAL_VAR_THIS = 'this';
    public const SPECIAL_VAR_ORIGIN = 'origin';
    public const SPECIAL_VAR_RUNNINGFUNCTION = 'runningfunction';

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

                //special vars
                switch ($this->name) {
                    case self::SPECIAL_VAR_THIS:
                        return new DataReturnLoad($currentEnvironment->getObject());
                    case self::SPECIAL_VAR_RUNNINGFUNCTION:
                        return new DataReturnLoad(new RunningFunctionData($currentEnvironment));
//            case self::SPECIAL_VAR_ORIGIN: //dont have rly access to it here
                }

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
                //TODO !!! if var is an extended Object, use this_object_call ...
                //TODO if I have technology to recognize which objects are extended:
                // add a certain $ this variable, which is the object the function is called on.
                // when a parent call: dont change the $ this variable.
                // in getFunction record the object on call and in ExecuteFunction just pass this var into the new RunningFunction

                $value = $this->scope->getObjectPubliclyAvailableVar($this->name);
        }
        if ($value === null) {
            $value = new Undefined();
        }

        return new DataReturnLoad($value);
    }


    public function set(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler, ?DataInterface $value): ReturnLoad
    {
        //special vars
        switch ($this->name) {
            case self::SPECIAL_VAR_THIS:
            case self::SPECIAL_VAR_RUNNINGFUNCTION:
            case self::SPECIAL_VAR_ORIGIN:
                $r = $exHandler->handle(new SpecialVariableOverwriteProtectionException());
                return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
        }

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
                    $r = $exHandler->handle(new CannotChangeForeignObjectException());
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
                }
                $currentEnvironment->getObject()->setPublicAndProtectedVariable($this->name, $value);
                break;

            default: //case self::SCOPE_FOREIGN_OBJECT_CALL
                if ($this->visibility !== FunctionObject::VISIBILITY_PRIVATE) {
                    $r = $exHandler->handle(new CannotChangeForeignObjectException());
                    return new ExceptionReturnLoad(new ExecutionResult(new ReturningExceptionAction($r->getHandler(), new ExecutionResult())));
                }

                $this->scope->setObjectOuterVar($this->name, $value);
        }

        return new DataReturnLoad($value);
    }


}