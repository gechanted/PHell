<?php

namespace PHell\Operators;

use PHell\Flow\Functions\FunctionObject;

interface ScopeAffected
{
    /**
     * this can only be Variable and getFunction
     */

    public const SCOPE_INNER_OBJECT = 'inner';
    public const SCOPE_FOREIGN_OBJECT_CALL = 'outer';
    public const SCOPE_THIS_OBJECT_CALL = 'this';

    public function changeScope(string|FunctionObject $scope): void;
}