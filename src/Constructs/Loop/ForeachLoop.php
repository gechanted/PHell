<?php
namespace PHell\Constructs\Loop;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Data\Datatypes\ArrayType;
use PHell\Flow\Exceptions\ForeachStatementNotArrayException;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Functions\RunningPHPFunction;
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
use PHell\Operators\Variable;

class ForeachLoop implements Command
{
    public function __construct(
        private readonly Statement $array,
        private readonly ?Variable  $keyVariable,
        private readonly Variable  $valueVariable,
        private readonly Code      $code)
    {
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $RL = $this->array->getValue($currentEnvironment, $exHandler);
        if ($RL instanceof DataReturnLoad === false) { return EasyStatement::returnLoadToExecutionResult($RL); }

        $validator = new ArrayType();
        $value = $RL->getData();
        if ($validator->validate($value)->isSuccess() === false) {
            $exceptionResult = $exHandler->handle(new ForeachStatementNotArrayException($value));
            if ($exceptionResult instanceof ExceptionHandlingResultNoShove) {
                return new ExecutionResult(new ReturningExceptionAction($exceptionResult->getHandler(), $exceptionResult->getExecutionResult()));
            }
            if ($exceptionResult instanceof ExceptionHandlingResultShove === false) {
                throw new ShouldntHappenException();
            }
            $shoveValue = $exceptionResult->getShoveBackValue();
            if ($validator->validate($shoveValue)->isSuccess()) {
                $value = $shoveValue->v();
            } else {
                return new ExecutionResult();
            }
        }

        if (is_iterable($value->v()) === false) {
            throw new ShouldntHappenException();
        }

        foreach ($value->v() as $key => $item) {
            $this->valueVariable->set($currentEnvironment, $exHandler, $item);
            $this->keyVariable?->set($currentEnvironment, $exHandler, RunningPHPFunction::convertPHPValue($key));

            //execute
            foreach ($this->code->getCommands() as $statement) {
                $executionResult = $statement->execute($currentEnvironment, $exHandler);
                if ($executionResult->isActionRequired()) {
                    $action = $executionResult->getAction();
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
                    return $executionResult;
                }
            }
        }

        return new ExecutionResult();
    }
}