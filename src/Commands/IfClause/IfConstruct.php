<?php

namespace PHell\Commands\IfClause;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Data\Boolea;
use PHell\Flow\Data\Datatypes\BooleanType;
use PHell\Flow\Functions\RunningFunction;
use Phell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\Returns\DataReturnLoad;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;

class IfConstruct implements Command
{

    /**
     * @param IfClause[] $ifClauses
     * @param Code|null $else
     */
    public function __construct(private array $ifClauses, ?Code $else = null)
    {
        $this->ifClauses[] = new IfClause(new Boolea(true), $else);
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $validator = new BooleanType();
        foreach ($this->ifClauses as $clause) {
            $RL = $clause->getCondition()->getValue($currentEnvironment, $exHandler);
            if ($RL instanceof ExceptionReturnLoad) { return $RL->getExecutionResult(); }
            if ($RL instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }

            $value = $RL->getData();
            $result = $validator->validate($value);
            if ($result->isSuccess()) {
                if ($value instanceof Boolea && $value->getBool() === true) {
                    return $clause->execute($currentEnvironment, $exHandler);
                }
            } else {
                //TODO ! if result not a bool throw
            }
        }
       return new ExecutionResult();
    }
}