<?php

namespace PHell\Commands\Loop;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\BooleanType;
use PHell\Flow\Exceptions\LoopStatementNotBoolException;
use PHell\Flow\Functions\RunningFunction;
use Phell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use Phell\Flow\Main\CommandActions\BreakAction;
use Phell\Flow\Main\CommandActions\ContinueAction;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use Phell\Flow\Main\Returns\ExceptionReturnLoad;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Flow\Main\Statement;

class DoWhileLoop implements Command
{
    public function __construct(
        private readonly Code                $doCode,
        private readonly Statement $whileLoopParenthesis,
        private readonly Code                $whileCode
    ){}

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $validator = new BooleanType();
        while (true) {

            //execute do code
            foreach ($this->doCode->getStatements() as $statement) {
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

            $RL = $this->whileLoopParenthesis->getValue($currentEnvironment, $exHandler);
            if ($RL instanceof ExceptionReturnLoad) { return $RL->getExecutionResult(); } //TODO RLs are fucked
            if ($RL instanceof DataReturnLoad === false) { throw new ShouldntHappenException(); }

            $value = $RL->getData();
            if ($validator->validate($value)->isSuccess() === false) {

                $exceptionResult = $exHandler->transmit(new LoopStatementNotBoolException($value));
                if ($exceptionResult instanceof ExceptionHandlingResultNoShove) {
                    return new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), $exceptionResult->getExecutionResult()));
                }
                if ($exceptionResult instanceof ExceptionHandlingResultShove === false) {
                    throw new ShouldntHappenException();
                }
                $shoveValue = $exceptionResult->getShoveBackValue();
                if ($validator->validate($shoveValue)->isSuccess()) {
                    $value = $shoveValue;
                }
            }

            if ($value->v() === false) {
                return new ExecutionResult();
            }

            foreach ($this->whileCode->getStatements() as $statement) {
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