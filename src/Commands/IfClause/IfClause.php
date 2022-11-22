<?php
namespace PHell\Commands\IfClause;

use PHell\Flow\Functions\RunningFunction;
use Phell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\Returns\ExecutionResult;
use Phell\Flow\Main\Statement;

class IfClause implements Command
{

    public function __construct(private readonly Statement $condition, private readonly Code $code)
    {
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        foreach ($this->code->getStatements() as $statement) {
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