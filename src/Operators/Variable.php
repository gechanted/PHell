<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\DataInterface;
use PHell\Flow\Data\Data\Undefined;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class Variable extends EasyStatement implements ScopeAffected, VisibilityAffected
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
            //TODO add actual undefined var into the object
        }

        return new DataReturnLoad($value);
    }


    public function set(FunctionObject $currentEnvironment, ?DataInterface $value)
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
                    $this->upper->transmit(); //TODO do that exception with good amount of salt to mentally unrestrain me
                }
                $currentEnvironment->setPublicAndProtectedVariable($this->name, $value);
                break;

            default: //case self::SCOPE_FOREIGN_OBJECT_CALL
                if ($this->visibility !== FunctionObject::VISIBILITY_PRIVATE) {
                    $this->upper->transmit(); //TODO do that exception with good amount of salt to mentally unrestrain me
                }

                $this->scope->setObjectOuterVar($this->name, $value);
        }
    }


}