<?php

namespace PHell\Operators;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\Returns\ExecutionResult;

class PublicOperator implements Command
{

    public function __construct(private readonly VisibilityAffected&Command $command)
    {
        $this->command->changeVisibility(FunctionObject::VISIBILITY_PUBLIC);
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        return $this->command->execute($currentEnvironment, $exHandler);
    }
}