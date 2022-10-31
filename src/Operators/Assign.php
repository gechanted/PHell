<?php

namespace PHell\Operators;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\ReturnLoad;
use PHell\Flow\Main\Statement;

class Assign extends EasyStatement implements VisibilityAffected
{

    //TODO split into assign and newVar

    private string $visibility = FunctionObject::VISIBILITY_PRIVATE;

    public function __construct(private readonly Variable $variable, private readonly Statement $statement)
    {
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        switch ($this->scope) {

            case self::SCOPE_INNER_OBJECT:
                switch ($this->visibility){
                    case FunctionObject::VISIBILITY_PUBLIC:
//                        $currentEnvironment->
                        // if there throw
                        //assign
                        break;
                    case FunctionObject::VISIBILITY_PROTECTED:
                        //if there throw
                        //assign
                        break;
                    default:
                        //assign
                }

        }
    }

    public function changeVisibility(string $visibility)
    {
        $this->visibility = $visibility;
    }
}