<?php

namespace PHell\Commands\TryCatch;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use Phell\Flow\Main\Code;
use Phell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use Phell\Flow\Main\CommandActions\ReturningExceptionAction;
use Phell\Flow\Main\CommandActions\ShoveAction;
use PHell\Flow\Main\Returns\ExceptionHandlingResult;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use PHell\Flow\Main\Returns\ExecutionResult;
use PHell\Operators\Variable;

class TryConstruct implements CodeExceptionHandler, Command
{
    private ?RunningFunction $currentEnvironment;
    private ?CodeExceptionHandler $exHandler;

    /**
     * @param CatchClause[] $catchClauses
     */
    public function __construct(
        private readonly Code      $code,
        private readonly array     $catchClauses = [],
        private readonly ?Code     $elseClauseCode = null,
        private readonly ?Variable $elseClauseVariable = null)
    {
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $this->currentEnvironment = $currentEnvironment;
        $this->exHandler = $exHandler;
        foreach ($this->code->getStatements() as $statement) {
            $result = $statement->execute($currentEnvironment, $this); //here is the new CodeExceptionTransmitter injected
            if ($result->isActionRequired()) {

                if ($result instanceof ReturningExceptionAction) {
                    //validate this is acceptor
                    if ($result->getHandler() === $this) {
                        return $result->getExecutionResult();
                    }
                }
                return $result;
            }
        }
        return new ExecutionResult();
    }

    public function transmit(FunctionObject $exception): ExceptionHandlingResult
    {
        foreach ($this->catchClauses as $catch) {
            $validation = $catch->getObjectValidator()->validate($exception);
            if ($validation->isSuccess()) {
                return $this->executeCatch($exception, $catch->getCode(), $catch->getVariable());
            }
        }
        if ($this->elseClauseCode !== null) {
            return $this->executeCatch($exception, $this->elseClauseCode, $this->elseClauseVariable);
        }

        return $this->exHandler->transmit($exception);
    }

    private function executeCatch(FunctionObject $exception, Code $code, ?Variable $variable): ExceptionHandlingResult
    {
        if ($variable !== null) {
            $variable->set($this->currentEnvironment, $this->exHandler, $exception);
        }

        foreach ($code->getStatements() as $statement) {

            $result = $statement->execute($this->currentEnvironment, $this->exHandler);
            if ($result->isActionRequired()) {

                if ($result instanceof ShoveAction) { //TODO if Shove without data
                    return new ExceptionHandlingResultShove($this, $result->getData());
                }

                return new ExceptionHandlingResultNoShove($this, new ExecutionResult(new ReturningExceptionAction($this, $result)));
            }
        }
        return new ExceptionHandlingResultNoShove($this, new ExecutionResult());
    }
}