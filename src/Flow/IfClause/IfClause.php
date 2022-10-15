<?php
namespace PHell\Flow\IfClause;

use PHell\Code\Code;
use PHell\Code\EasyCommand;
use PHell\Code\ExecutionResult;
use PHell\Code\Statement;
use PHell\Flow\Functions\FunctionObject;

class IfClause extends EasyCommand
{

    public function __construct(private readonly Statement $condition, private readonly Code $code)
    {
    }

    public function exec(FunctionObject $currentEnvironment): ExecutionResult
    {
        foreach ($this->code->getStatements() as $statement) {
            $result = $statement->execute($currentEnvironment, $this);
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