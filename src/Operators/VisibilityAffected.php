<?php

namespace PHell\Operators;

interface VisibilityAffected
{
    /**
     * this can only be Assign and newFunction
     */

    public function changeVisibility(string $visibility): void;
}