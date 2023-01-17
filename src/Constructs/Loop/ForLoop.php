<?php

namespace PHell\Constructs\Loop;

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
        foreach ($this->setupCode->getCommands() as $statement) {
            $result = $statement->execute($currentEnvironment, $exHandler);
            if ($result->isActionRequired()) {
                return $result;
            }
        }

        $code = new Code($this->executionCode->getCommands());
        foreach ($this->incrementCode as $increment) {
            $code->addCommand($increment);
        }

        $loop = new DoWhileLoop(new Code(), $this->forLoopParenthesis, $code);

        return $loop->execute($currentEnvironment, $exHandler);
    }

}