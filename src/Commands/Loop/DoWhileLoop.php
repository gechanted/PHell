<?php

namespace PHell\Commands\Loop;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\BooleanType;
use PHell\Flow\Exceptions\LoopStatementNotBoolException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\CommandActions\BreakAction;
use PHell\Flow\Main\CommandActions\ContinueAction;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\EasyStatement;
use PHell\Flow\Main\Returns\DataReturnLoad;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use PHell\Flow\Main\Returns\ExceptionReturnLoad;
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
            foreach ($this->doCode->getCommands() as $statement) {
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
            if ($RL instanceof DataReturnLoad === false) { return EasyStatement::returnLoadToExecutionResult($RL); }

            $value = $RL->getData();
            if ($validator->validate($value)->isSuccess() === false) {

                $exceptionResult = $exHandler->handle(new LoopStatementNotBoolException($value));
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

            foreach ($this->whileCode->getCommands() as $statement) {
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