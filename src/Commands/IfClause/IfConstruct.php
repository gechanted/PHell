<?php

namespace PHell\Commands\IfClause;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\Boolea;
use PHell\Flow\Data\DatatypeValidators\BooleanTypeValidator;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\Code;
use Phell\Flow\Main\EasyCommand;
use PHell\Flow\Main\Returns\DataReturnLoad;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;

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

    protected function exec(FunctionObject $currentEnvironment): ExecutionResult
    {
        $validator = new BooleanTypeValidator();
        foreach ($this->ifClauses as $clause) {
            $RL = $clause->getCondition()->getValue($currentEnvironment, $this->upper);
            if ($RL instanceof ExceptionReturnLoad) { return $RL->getExecutionResult(); }
            if ($RL instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }

            $value = $RL->getData();
            $result = $validator->validate($value);
            if ($result->isSuccess()) {
                if ($value instanceof Boolea && $value->getBool() === true) {
                    return $clause->execute($currentEnvironment, $this->upper);
                }
            } else {
                //TODO ? if result not a bool throw
            }
        }
       return new ExecutionResult();
    }
}