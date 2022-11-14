<?php

namespace PHell\Operators;

use PHell\Flow\Functions\FunctionObject;

interface ScopeAffected
{
    /**
     * this can only be Variable and getFunction
     */

    public const SCOPE_INNER_OBJECT = 'inner';
    public const SCOPE_FOREIGN_OBJECT_CALL = 'outer'; //won't be set, instead there is the foreign object given in, for use
    public const SCOPE_THIS_OBJECT_CALL = 'this';

    public function changeScope(string|FunctionObject $scope): void;
}