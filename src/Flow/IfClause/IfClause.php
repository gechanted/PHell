<?php
namespace PHell\Flow\IfClause;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\EasyCommand;
use PHell\Flow\Main\ExecutionResult;
use PHell\Flow\Main\Statement;

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