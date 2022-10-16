<?php

namespace PHell\Flow\IfClause;

use PHell\Flow\Data\Data\Boolea;
use PHell\Flow\Data\DatatypeValidators\BooleanTypeValidator;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\EasyCommand;
use PHell\Flow\Main\ExecutionResult;

class IfConstruct extends EasyCommand
{

    /**
     * @param IfClause[] $ifClauses
     * @param Code|null $else
     */
    public function __construct(private array $ifClauses, ?Code $else = null)
    {
        $this->ifClauses[] = new IfClause(new Boolea(true), $else);
    }

    public function exec(FunctionObject $currentEnvironment): ExecutionResult
    {
        $validator = new BooleanTypeValidator();
        foreach ($this->ifClauses as $clause) {
            $value = $clause->getCondition()->getValue();
            $result = $validator->validate($value);
            if ($result->isSuccess() && $value instanceof Boolea &&$value->getValue === true) // TODO !!!
            {
                return $clause->exec($currentEnvironment);
            }
        }
       return new ExecutionResult();
    }
}