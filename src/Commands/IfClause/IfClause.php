<?php
namespace PHell\Commands\IfClause;

use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\Code;
use Phell\Flow\Main\EasyCommand;
use PHell\Flow\Main\Returns\ExecutionResult;
use Phell\Flow\Main\Statement;

class IfClause extends EasyCommand
{

    public function __construct(private readonly Statement $condition, private readonly Code $code)
    {
    }

    protected function exec(FunctionObject $currentEnvironment): ExecutionResult
    {
        foreach ($this->code->getStatements() as $statement) {
            $result = $statement->execute($currentEnvironment, $this->upper);
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