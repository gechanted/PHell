<?php
namespace PHell\Constructs\IfClause;

use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Statement;

class IfClause implements Command
{

    public function __construct(private readonly Statement $condition, private readonly Code $code)
    {
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        foreach ($this->code->getCommands() as $statement) {
            $result = $statement->execute($currentEnvironment, $exHandler);
            if ($result->isActionRequired()) {
                return $result;
            }
        }
        return new ExecutionResult();
    }

    public function getCondition(): Statement
    {
        return $this->condition;
    }
}