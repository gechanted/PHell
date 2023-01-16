<?php

namespace PHell\Commands\TryCatch;

use PHell\Flow\Functions\FunctionObject;
use PHell\Flow\Functions\RunningFunction;
use PHell\Flow\Main\Code;
use PHell\Flow\Main\CodeExceptionHandler;
use PHell\Flow\Main\Command;
use PHell\Flow\Main\CommandActions\ReturningExceptionAction;
use PHell\Flow\Main\CommandActions\ShoveAction;
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
        private readonly Code  $code,
        private readonly array $catchClauses = [],
        private readonly Code $finally = new Code(),
    ) {
    }

    public function execute(RunningFunction $currentEnvironment, CodeExceptionHandler $exHandler): ExecutionResult
    {
        $this->currentEnvironment = $currentEnvironment;
        $this->exHandler = $exHandler;
        foreach ($this->code->getCommands() as $statement) {
            $result = $statement->execute($currentEnvironment, $this); //here is the new CodeExceptionHandler injected
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

        // !! a word about finally !!
        //usually finally would be executed here
        //but not here, the definition of finally is so unclear that I completely hate it

        return new ExecutionResult();
    }

    public function handle(FunctionObject $exception): ExceptionHandlingResult
    {
        //check clauses, for fit & execute fit
        foreach ($this->catchClauses as $catch) {
            $validation = $catch->getObjectValidator()->validate($exception);
            if ($validation->isSuccess()) {
                return $this->executeCatch($exception, $catch->getCode(), $catch->getVariable());
            }
        }

        $handlingResult = $this->exHandler->handle($exception);
        //finally
        if ($handlingResult instanceof ExceptionHandlingResultNoShove) {
            //no catch clause did work & no shove
            foreach ($this->finally->getCommands() as $command) {
                $command->execute($this->currentEnvironment, $this->exHandler);
                //Command actions are just ignored
                //because I hate that it can actually break the control flow of exceptions in php
                //TODO maybe change this to an exception so people wont be confused to why their stuff isnt happening
            }
        }


        return $handlingResult;
    }

    private function executeCatch(FunctionObject $exception, Code $code, ?Variable $variable): ExceptionHandlingResult
    {
        if ($variable !== null) {
            $variable->set($this->currentEnvironment, $this->exHandler, $exception);
        }

        foreach ($code->getCommands() as $statement) {

            $result = $statement->execute($this->currentEnvironment, $this->exHandler);
            if ($result->isActionRequired()) {

                if ($result instanceof ShoveAction) { //if Shove without data: Void is used
                    return new ExceptionHandlingResultShove($this, $result->getData());
                }

                return new ExceptionHandlingResultNoShove($this, new ExecutionResult(new ReturningExceptionAction($this, $result)));
            }
        }
        return new ExceptionHandlingResultNoShove($this, new ExecutionResult());
    }
}