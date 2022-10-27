<?php

namespace PHell\Operators;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\EasyCommand;
use PHell\Flow\Main\Returns\ExecutionResult;

class ProtectedOperator extends EasyCommand
{

    public function __construct(private readonly VisibilityAffected&Command $command)
    {
        $this->command->changeVisibility(FunctionObject::VISIBILITY_PROTECTED);
    }

    protected function exec(FunctionObject $currentEnvironment): ExecutionResult
    {
        return $this->command->execute($currentEnvironment, $this->upper);
    }
}