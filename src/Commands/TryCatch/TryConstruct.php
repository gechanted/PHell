<?php
namespace PHell\Commands\TryCatch;

use PHell\Exceptions\ShouldntHappenException;
use PHell\Flow\Functions\FunctionObject;
use Phell\Flow\Main\Code;
use Phell\Flow\Main\CodeExceptionTransmitter;
use Phell\Flow\Main\CommandActions\ShoveAction;
use Phell\Flow\Main\EasyCommand;
use Phell\Flow\Main\ExceptionHandlingResult;
use PHell\Flow\Main\Returns\ExceptionHandlingResultNoShove;
use PHell\Flow\Main\Returns\ExceptionHandlingResultShove;
use PHell\Flow\Main\Returns\ExecutionResult;

class TryConstruct extends EasyCommand implements CodeExceptionTransmitter
{
    private ?FunctionObject $currentEnvironment;

    /**
     * @param Code $code
     * @param CatchClause[] $catchClauses
     */
    public function __construct(private readonly Code $code, private readonly array $catchClauses)
    {
    }

    protected function exec(FunctionObject $currentEnvironment): ExecutionResult
    {
        $this->currentEnvironment = $currentEnvironment;
        foreach ($this->code->getStatements() as $statement) {
            $result = $statement->execute($currentEnvironment, $this); //here is the new CodeExceptionTransmitter injected
            if ($result->isActionRequired()) {

                if ()

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


                if ($this->currentEnvironment === null) {
                    throw new ShouldntHappenException();
                }
                foreach ($this->code->getStatements() as $statement) {

                    $result = $statement->execute($this->currentEnvironment, $this->upper);
                    if ($result->isActionRequired()) {

                        if ($result instanceof ShoveAction) {
                            return new ExceptionHandlingResultShove($result->getData());
                        }

                        return new ExceptionHandlingResultNoShove($result);
                    }
                }
                return new ExceptionHandlingResultNoShove(new Ex);
            }
        }
    }
}