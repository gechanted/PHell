<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\UnexecutedFunctionCollection;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class GetFunctionCollection extends EasyStatement implements ScopeAffected
{

    private string|FunctionObject $scope = ScopeAffected::SCOPE_INNER_OBJECT;

    public function __construct(private readonly string $name)
    {
    }

    public function getValue(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ReturnLoad
    {
        switch ($this->scope) {
            case ScopeAffected::SCOPE_INNER_OBJECT:
                return new DataReturnLoad(new UnexecutedFunctionCollection($currentEnvironment->getObject()->getNormalFunction($this->name)));
            case ScopeAffected::SCOPE_THIS_OBJECT_CALL:
                return new DataReturnLoad(new UnexecutedFunctionCollection($currentEnvironment->getObject()->getInnerObjectFunction($this->name)));
            default :
                //scope is either a string or a FunctionObject
                if ($this->scope instanceof FunctionObject === false) {
                    throw new ShouldntHappenException();
                }
                // checks if this Object is a parent
                if ($currentEnvironment->getObject()->checkExtensionRecursion($this->scope) === false) {
                    return new DataReturnLoad(new UnexecutedFunctionCollection($this->scope->getInnerObjectFunction($this->name)));
                }
//                else if($currentEnvironment->isDifferentOrigin() && $this->scope === $currentEnvironment->getObject()->getNormalVar(Variable::SPECIAL_VAR_ORIGIN)) {
//                    return new DataReturnLoad(new UnexecutedFunctionCollection($currentEnvironment->getDifferentOrigin()->getInnerObjectFunction($this->name)));
//                }

        return new DataReturnLoad(new UnexecutedFunctionCollection($this->scope->getObjectPubliclyAvailableFunction($this->name)));
        }
    }

    public function changeScope(string|FunctionObject $scope): void
    {
        $this->scope = $scope;
    }
}