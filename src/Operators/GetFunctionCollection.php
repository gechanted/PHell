<?php

namespace PHell\Operators;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\UnexecutedFunctionCollection;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ReturnLoad;

class GetFunctionCollection extends EasyStatement implements ScopeAffected
{

    private string|FunctionObject $scope = ScopeAffected::SCOPE_INNER_OBJECT;

    public function __construct(private readonly string $name)
    {
    }

    protected function value(FunctionObject $currentEnvironment): ReturnLoad
    {
        switch ($this->scope) {
            case ScopeAffected::SCOPE_INNER_OBJECT:
                return new DataReturnLoad(new UnexecutedFunctionCollection($currentEnvironment->getStackFunction($this->name)));
            case ScopeAffected::SCOPE_THIS_OBJECT_CALL:
                return new DataReturnLoad(new UnexecutedFunctionCollection($currentEnvironment->getOriginFunction($this->name)));
            default :
                if ($this->scope instanceof FunctionObject === false) {
                    throw new ShouldntHappenException();
                }
                return new DataReturnLoad(new UnexecutedFunctionCollection($currentEnvironment->getObjectPubliclyAvailableFunction($this->name)));
        }
    }

    public function changeScope(string|FunctionObject $scope): void
    {
        $this->scope = $scope;
    }
}