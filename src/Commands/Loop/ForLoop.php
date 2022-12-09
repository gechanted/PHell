<?php

namespace PHell\Commands\Loop;

use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Statement;

class ForLoop implements Command
{
    public function __construct(private readonly Code      $setupCode,
                                private readonly Statement $forLoopParenthesis,
                                private readonly Code      $executionCode,
                                private readonly Code      $incrementCode
    ){}

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        //TODO ! isnt implemented right: you forgot about increment !!!
        foreach ($this->setupCode->getStatements() as $statement) {
            $result = $statement->execute($currentEnvironment, $exHandler);
            if ($result->isActionRequired()) {
                return $result;
            }
        }

        $loop = new DoWhileLoop(new Code(), $this->forLoopParenthesis, $this->executionCode);

        return $loop->execute($currentEnvironment, $exHandler);
    }

}