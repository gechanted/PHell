<?php

namespace PHell\Commands\Loop;

use PHell\Flow\Data\Datatypes\IntegerType;
use PHell\Flow\Exceptions\TimesLoopException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\CommandActions\BreakAction;
use PHell\Flow\Main\CommandActions\ContinueAction;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Statement;

class TimesLoop implements Command
{

    public function __construct(private readonly Statement $timesCount, private readonly Code $code)
    {
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $rl = $this->timesCount->getValue($currentEnvironment, $exHandler);
        if ($rl instanceof DataReturnLoad === false) { return EasyStatement::returnLoadToExecutionResult($rl); }
        $value = $rl->getData();

        $validator = new IntegerType();
        if ($validator->validate($value)->isSuccess() === false) {
            $exResult = $exHandler->transmit(new TimesLoopException($value));
            return new ExecutionResult(new ReturningExceptionAction($exResult->getHandler(), new ExecutionResult()));
        }

        for ($i = 0; $i < $value->v(); $i++) {

            //execute code
            foreach ($this->code->getCommands() as $statement) {
                $result = $statement->execute($currentEnvironment, $exHandler);
                if ($result->isActionRequired()) {
                    $action = $result->getAction();
                    if ($action instanceof ContinueAction) {
                        if ($action->thisTime()) {
                            continue 2;
                        } else {
                            $action->decrement();
                            return new ExecutionResult($action);
                        }
                    } else if ($action instanceof BreakAction) {
                        if ($action->thisTime()) {
                            break 2;
                        } else {
                            $action->decrement();
                            return new ExecutionResult($action);
                        }
                    }
                    return $result;
                }
            }


        }
        return new ExecutionResult();
    }
}